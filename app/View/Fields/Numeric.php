<?php

namespace App\View\Fields;

use App\View\FieldInterface;

class Numeric implements FieldInterface
{
    public function configForm($data) 
    {
        return view('fields/setup/numeric', $data);
    }
    
    public function input($data) 
    {
        $data['type'] = 'number';
        
        return view('components/form/input', $data);
    }
}