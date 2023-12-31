<?php

namespace App\View\Fields;

use App\View\FieldInterface;

class Text implements FieldInterface
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
    
    public function field($data) 
    {
        $data['type'] = 'text';

        return view('components/form/form-group', $data);
    }
}