<?php

namespace Botble\Translation\Http\Controllers;

use Assets;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Translation\Manager;
use Illuminate\Http\Request;
use Botble\Translation\Models\Translation;
use Illuminate\Support\Collection;

class TranslationController extends BaseController
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * TranslationController constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getIndex(Request $request)
    {
        page_title()->setTitle(trans('plugins/translation::translation.menu_name'));

        Assets::addScripts(['bootstrap-editable'])
            ->addStyles(['bootstrap-editable'])
            ->addScriptsDirectly($this->manager->getConfig('assets_dir') . '/js/translation.js')
            ->addStylesDirectly(['/vendor/core/plugins/translation/css/translation.css']);

        $group = $request->input('group');

        $locales = $this->loadLocales();
        $groups = Translation::groupBy('group');
        $excludedGroups = $this->manager->getConfig('exclude_groups');
        if ($excludedGroups) {
            $groups->whereNotIn('group', $excludedGroups);
        }

        $groups = $groups->select('group')->get()->pluck('group', 'group');
        if ($groups instanceof Collection) {
            $groups = $groups->all();
        }
        $groups = ['' => trans('plugins/translation::translation.choose_a_group')] + $groups;
        $numChanged = Translation::where('group', $group)->where('status', Translation::STATUS_CHANGED)->count();


        $allTranslations = Translation::where('group', $group)->orderBy('key', 'asc')->get();
        $numTranslations = count($allTranslations);
        $translations = [];
        foreach ($allTranslations as $translation) {
            $translations[$translation->key][$translation->locale] = $translation;
        }

        return view('plugins/translation::index')
            ->with('translations', $translations)
            ->with('locales', $locales)
            ->with('groups', $groups)
            ->with('group', $group)
            ->with('numTranslations', $numTranslations)
            ->with('numChanged', $numChanged)
            ->with('editUrl', route('translations.group.edit', ['group' => $group]))
            ->with('deleteEnabled', $this->manager->getConfig('delete_enabled'));
    }

    /**
     * @return array
     */
    protected function loadLocales()
    {
        //Set the default locale as the first one.
        $locales = Translation::groupBy('locale')
            ->select('locale')
            ->get()
            ->pluck('locale');

        if ($locales instanceof Collection) {
            $locales = $locales->all();
        }
        $locales = array_merge([config('app.locale')], $locales);

        return array_unique($locales);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdd(Request $request)
    {
        $keys = explode("\n", $request->get('keys'));

        foreach ($keys as $key) {
            $key = trim($key);
            if ($request->input('group') && $key) {
                $this->manager->missingKey('*', $request->input('group'), $key);
            }
        }
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {
        $group = $request->input('group');

        if (!in_array($group, $this->manager->getConfig('exclude_groups'))) {
            $name = request()->get('name');
            $value = request()->get('value');

            [$locale, $key] = explode('|', $name, 2);
            $translation = Translation::firstOrNew([
                'locale' => $locale,
                'group'  => $group,
                'key'    => $key,
            ]);
            $translation->value = (string)$value ?: null;
            $translation->status = Translation::STATUS_CHANGED;
            $translation->save();
            return ['status' => 'ok'];
        }
    }

    /**
     * @param Request $request
     * @param $key
     * @return array
     */
    public function postDelete(Request $request)
    {
        $group = $request->input('group');

        if (!in_array($group,
                $this->manager->getConfig('exclude_groups')) && $this->manager->getConfig('delete_enabled')) {
            Translation::where('group', $group)->where('key', $request->input('key'))->delete();
            return ['status' => 'ok'];
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function postImport(Request $request)
    {
        $replace = $request->get('replace', false);
        $counter = $this->manager->importTranslations($replace);

        return [
            'status'  => 'ok',
            'counter' => $counter,
        ];
    }

    /**
     * @return array
     */
    public function postFind()
    {
        $numFound = $this->manager->findTranslations();

        return [
            'status'  => 'ok',
            'counter' => (int)$numFound,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function postPublish(Request $request)
    {
        $json = false;

        $group = $request->input('group');

        if ($group === '_json') {
            $json = true;
        }

        $this->manager->exportTranslations($group, $json);

        return [
            'status' => 'ok',
        ];
    }
}
