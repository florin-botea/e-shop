<?php

namespace App\Admin\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
* This route handle model props and relationship management
*/
class EntityController extends Controller
{
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function create() 
    {
        $data['form_entity']['action'] = route('admin/system/block_layout');
        $data['form_entity']['method'] = 'POST';
        
        return view('system/entity/form', $data);
    }
}
    