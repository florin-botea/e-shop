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
 
        if (!empty($data['multilang'])) {
            return view('components/form/input-multilang', $data);
        }  
      
        return view('components/form/input', $data);
    }
}