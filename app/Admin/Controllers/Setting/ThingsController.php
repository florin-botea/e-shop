<?php

namespace App\Admin\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Store;

/**
 * This route handles adding layouts to be consumed by controllers.
 * A layout have an unique code, which can't be edited after save.
 */
class ThingsController extends Controller
{
    protected $request;

    public function __construct(Request $request) 
    {
        $this->request = $request;
    }
    
    public function index()
    {
      $data = [];
      $data['collection'] = [];
      
      return view('setting/things/index', $data);
    }
    
    public function create() 
    {
    }
    
    public function store() 
    {
    }
    
    public function edit() 
    {
    }
    
    public function update() 
    {
    }
    
    protected function form()
    {
    }
}