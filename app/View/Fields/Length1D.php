<?php

namespace App\View\Fields;

use App\View\AbstractField;

class Length1D extends AbstractField
{
    public function configForm($data) 
    {
        return view('fields/setup/length_1d', $data);
    }
    
    public function field() 
    {
        $view = $this->data;

        $length_units = [];
        $length_classes = app('length_classes');
        foreach ($length_classes as $length_class) {// todo helper to options
            $length_units[] = [
                'label' => $length_class->name,
                'value' => $length_class->name, // todo code
            ];
        }
   
        $model = $this->form->getModel();
        $settings = $this->formField->field['settings'] ?? [];
        $view = array_merge($view, $settings);
        $view['unit']['options'] = $length_units;
        if ($model->id) {
            $view['unit']['value'] = $model[$settings['unit']['name']];
        }

        return view('fields/length_1d', $view);
    }
}