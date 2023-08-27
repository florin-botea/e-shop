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
// $x = require(base_path('../database/migrations/2023_02_17_175413_create_products_table.php'));
// $x->down();
// $x->up();
        
        $record = Product::firstOrCreate(); // type draft for this user
        
        $MODEL = $record;
        $action = '/admin/catalog/product'; // todo
        $method = 'POST';
        $crud_product_description = route('crud.product.description', ['product_id' => $record->id]);
        
        $data = compact('action', 'method', 'crud_product_description');
        return view('catalog/product/form', $data);
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
