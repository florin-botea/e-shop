<?php

namespace App\View\Fields;

use App\View\AbstractField;

class CategorySelect extends AbstractField
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
        


        return view('components/form/form-group', $view);
    }
    
    public function viewPath()
    {
        return 'fields/category_select';
    }
    
    public function validate($data)
    {
        
    }
}