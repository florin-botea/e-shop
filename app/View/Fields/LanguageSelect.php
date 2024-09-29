<?php

namespace App\View\Fields;

use App\View\AbstractField;

class LanguageSelect extends AbstractField
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
    {dd($this->data);
        $view = $this->data;
        $view['type'] = 'select';
        


        return view('components/form/form-group', $view);
    }
    
    public function viewPath()
    {
        return 'fields/language_select';
    }
    
    public function validate($data)
    {
        
    }
}