<?php

namespace App\View\Fields;

use App\View\FieldInterface;

class Select implements FieldInterface
{
    public function configForm($data) 
    {
        return view('fields/setup/select', $data);
    }
    
    public function input($data) 
    {
        $data['type'] = 'select';
        
        return view('components/form/input', $data);
    }
}