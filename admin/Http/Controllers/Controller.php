<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected $request;
    
    public function __construct(Request $request) 
    {
        $this->request = $request;
    }
}
