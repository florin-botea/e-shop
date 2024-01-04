<?php

namespace App\View\Fields;

use App\View\FieldInterface;

class Checkbox implements FieldInterface
{
    public function configForm($data) 
    {
        return view('fields/setup/numeric', $data);
    }
    
    public function input($data) 
    {
        return view('components/form/form-check', $data);
    }
    
    public function field($data) 
    {
        return view('components/form/form-check', $data);
    }    
}