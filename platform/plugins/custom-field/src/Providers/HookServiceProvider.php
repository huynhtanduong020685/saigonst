<?php

namespace Botble\CustomField\Providers;

use Assets;
use CustomField;
use Eloquent;
use Illuminate\Support\Facades\Auth;
use Botble\ACL\Repositories\Interfaces\RoleInterface;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\CustomField\Facades\CustomFieldSupportFacade;
use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_action(BASE_ACTION_META_BOXES, [$this, 'handle'], 125, 3);
    }

    /**
     * @param string $screen
     * @param string $priority
     * @param Eloquent $object
     * @throws Throwable
     */
    public function handle($screen, $priority, $object = null)
    {
        if (CustomField::isSupportedModule($screen) && $priority == 'advanced') {
            add_custom_fields_rules_to_check([
                $screen      => isset($object->id) ? $object->id : null,
                'model_name' => $screen,
            ]);

            /**
             * Every models will have these rules by default
             */
            if (Auth::check()) {
                add_custom_fields_rules_to_check([
                    'logged_in_user'          => Auth::user()->getKey(),
                    'logged_in_user_has_role' => $this->app->make(RoleInterface::class)->pluck('id'),
                ]);
            }

            if (defined('PAGE_MODULE_SCREEN_NAME')) {
                switch ($screen) {
                    case PAGE_MODULE_SCREEN_NAME:
                        add_custom_fields_rules_to_check([
                            'page_template' => isset($object->template) ? $object->template : '',
                        ]);
                        break;
                }
            }

            if (defined('POST_MODULE_SCREEN_NAME')) {
                switch ($screen) {
                    case POST_MODULE_SCREEN_NAME:
                        if ($object) {
                            $relatedCategoryIds = $this->app->make(PostInterface::class)->getRelatedCategoryIds($object);
                            add_custom_fields_rules_to_check([
                                $screen . '.post_with_related_category' => $relatedCategoryIds,
                                $screen . '.post_format'                => $object->format_type,
                            ]);
                        }
                        break;
                }
            }

            echo $this->render($screen, isset($object->id) ? $object->id : null);
        }
    }

    /**
     * @param $screen
     * @param $id
     * @throws Throwable
     */
    protected function render($screen, $id)
    {
        $customFieldBoxes = get_custom_field_boxes($screen, $id);

        if (!$customFieldBoxes) {
            return null;
        }

        Assets::addStylesDirectly([
            'vendor/core/plugins/custom-field/css/custom-field.css',
        ])
            ->addScriptsDirectly(config('core.base.general.editor.ckeditor.js'))
            ->addScriptsDirectly([
                'vendor/core/plugins/custom-field/js/use-custom-fields.js',
            ])
            ->addScripts(['jquery-ui']);

        CustomFieldSupportFacade::renderAssets();

        return CustomFieldSupportFacade::renderCustomFieldBoxes($customFieldBoxes);
    }
}
