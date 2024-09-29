<?php

namespace App\View\Fields;

use App\View\AbstractField;

class AttributeSelect extends AbstractField
{
    public function configForm($data) 
    {return ''; // todo:
        return view('fields/setup/numeric', $data);
    }
    
    public function input($data) 
    {
        $data['type'] = 'text';

        return view('components/form/input', $data);
    }
    
    public function field() 
    {
        $view = $this->data;
        $view['type'] = 'select';
        $view['options'] = [];
        $attributes = model('catalog/attribute')->with('language')->get();
        foreach ($attributes as $attribute) {
            $view['options'][] = [
                'label' => $attribute->language->name,
                'value' => $attribute->id
            ];
        }

        return view('components/form/form-group', $view);
    }
}