<?php

namespace App\View\Fields;

use App\View\FieldInterface;

class LengthUnit implements FieldInterface
{
    public function configForm($data) 
    {
        return '';
    }
    
    public function input($data) 
    {
        $data['type'] = 'select';
        $data['options'] = [];
        $lemgth_classes = app('length_classes');
        foreach ($lemgth_classes as $lemgth_class) {
            $data['options'][] = [
                'label' => $lemgth_class->name,
                'value' => $lemgth_class->name, // todo code
            ];
        }
        
        return view('components/form/input', $data);
    }
}