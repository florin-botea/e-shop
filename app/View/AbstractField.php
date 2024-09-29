<?php

namespace App\View;

use App\Models\Setting\FormField;

class AbstractField
{
    protected $form;
    protected $formField;
    protected $data;
    // todo
    public function construct(Form $form, FormField $formField)
    {
        $this->form = $form;
        $this->formField = $formField;
        
        $this->data = [
            'name' => $formField->name,
            'label' => $formField->language->label,
            'helper' => $formField->language->helper,
            'mention' => $formField->language->mention,
            'placeholder' => $formField->language->placeholder,
            'value' => data_get($this->form->getModel(), $formField->name),
        ];
    }
}