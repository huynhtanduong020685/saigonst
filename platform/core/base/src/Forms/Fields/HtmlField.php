<?php

namespace Botble\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class HtmlField extends FormField
{
    /**
     * @inheritdoc
     */
    protected function getDefaults()
    {
        return [
            'html' => '',
            'wrapper'    => false,
            'label_show' => false,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAllAttributes()
    {
        // No input allowed for html fields.
        return [];
    }

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'core/base::forms.fields.html';
    }
}
