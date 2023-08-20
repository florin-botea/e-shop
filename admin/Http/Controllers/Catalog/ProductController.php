<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Product;

class ProductController extends Controller
{
    public function index() 
    {
        return view('layouts/app');
    }
    
    public function show($id) 
    {
        abort(404);
    }
    
    public function create() 
    {
        $product = new Product();
        $product->description = [];
        $product->description[1] = [
            'name' => 'set jucarii'
        ];
        
        $view['model'] = $product;
        
        $view['action'] = '/admin/catalog/product'; // todo
        $view['method'] = 'POST';
        
        return view('catalog/product/form', $view);
    }
    
    public function store(Request $request) 
    {
        $request->validate([
            'description.*.name' => 'required|min:3',
            'description.*.meta_title' => 'required|min:3',
        ]);
        
        $item = Product::create($request->all());
        
        
    }
    
    public function edit($id) 
    {
        abort(404);
    }
    
    public function update($id) 
    {
        abort(404);
    }
    
    public function destroy($id) 
    {
        abort(404);
    }
}
