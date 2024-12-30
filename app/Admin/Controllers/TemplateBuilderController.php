<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateBuilderController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }    
    
    public function __invoke()
    {
        $template = $this->request->post('template');
        $data = $this->request->post('data');
        
        set_error_handler(function() {
          return;
        });
        
        return view($template, $data);
    }
}