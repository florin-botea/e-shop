<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() 
    {
        dd(__FUNCTION__);
    }
    
    public function show($id) 
    {
        dd(__FUNCTION__.$id);
    }
    
    public function create() 
    {
        $form = [
            'action' => route('admin/sale/order.store'),
            'method' => 'POST'
        ];       
        dump(__FUNCTION__, $form);
        return view('form', $form);
    }
    
    public function store() 
    {
        dd(__FUNCTION__);
    }
    
    public function edit($id,$id2) 
    {
        $form = [
            'action' => route('admin/sale/order.update', ['sale'=>$id,'order' => $id2]),
            'method' => 'PUT'
        ];       
        dump(__FUNCTION__, $form);
        return view('form', $form);
    }
    
    public function update($id,$id2) 
    {
        dd(__FUNCTION__, $id2, $id);
    }
    
    public function destroy($id) 
    {
        dd(__FUNCTION__.$id);
    }
}
