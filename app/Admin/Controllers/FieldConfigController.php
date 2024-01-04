<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FieldConfigController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }    
    
    public function __invoke()
    {
        $field = app('fields')->make($this->request->get('field', ''));
        
        if (empty($field)) {
            abort(404);
        }

        $form = $field->configForm($this->request->all());
        $form .= app('fields')->validationForm();
        
        return $form;
    }
}