<?php

namespace Botble\Vendor\Forms;

use Assets;
use Botble\RealEstate\Models\Property;
use Botble\Vendor\Forms\Fields\CustomEditorField;
use Botble\Vendor\Forms\Fields\MultipleUploadField;
use Botble\Vendor\Http\Requests\PropertyRequest;

class PropertyForm extends \Botble\RealEstate\Forms\PropertyForm
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        parent::buildForm();

        Assets::addScriptsDirectly('vendor/core/libraries/tinymce/tinymce.min.js');

        if (!$this->formHelper->hasCustomField('customEditor')) {
            $this->formHelper->addCustomField('customEditor', CustomEditorField::class);
        }

        if (!$this->formHelper->hasCustomField('multipleUpload')) {
            $this->formHelper->addCustomField('multipleUpload', MultipleUploadField::class);
        }

        $this
            ->setupModel(new Property)
            ->setFormOption('template', 'plugins/vendor::forms.base')
            ->setFormOption('enctype', 'multipart/form-data')
            ->setValidatorClass(PropertyRequest::class)
            ->setActionButtons(view('plugins/vendor::forms.actions')->render())
            ->remove('is_featured')
            ->remove('content')
            ->remove('author_id')
            ->removeMetaBox('image')
            ->addAfter('description', 'content', 'customEditor', [
                'label'      => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label required'],
            ])
            ->addAfter('content', 'images', 'multipleUpload', [
                'label'      => __('Images'),
                'label_attr' => ['class' => 'control-label'],
            ]);
    }
}
