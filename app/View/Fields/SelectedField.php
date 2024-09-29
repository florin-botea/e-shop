<?php

namespace App\View\Fields;

use App\View\AbstractField;
use App\View\Form;
use App\Models\Setting\FormField;

class SelectedField extends AbstractField
{
    public function configForm($data)
    {
        return view('fields/setup/selected_field', $data);
    }

    public function input($data)
    {
        $fields = app('fields');
        $view['options'] = $fields->toSelectOptions();

        return view('fields/field_select', $view);
    }

    public function field()
    {
        $config_key = $this->formField->field['settings']['source'];
        $model = $this->form->getModel();
        $field = data_get($model, $config_key);
        $class = $field['type'];
        $this->formField->field = $field;
        $field = new $class($this->form, $this->formField);
        
        return $field->field();
        // return view('fields/field_select', $this->data);
    }
}