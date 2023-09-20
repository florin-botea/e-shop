<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Product;

class ProductController extends Controller
{
    public function index(Product $product) 
    {
        $data['collection'] = $product->with('description')->paginate();

        return view('catalog/product/index', $data);
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
        
        $_model = $record;
        $action = '/admin/catalog/product'; // todo
        $method = 'POST';
        $crud_product_description = route('crud.product.description', ['product_id' => $record->id]);
        
        $data = compact('action', 'method', 'crud_product_description', '_model');
        return view('catalog/product/form', $data);
    }
    
    public function store(Request $request) 
    {
        $request->validate([
            'model' => 'required|min:3',
        ]);
        
        $item = Product::create($request->all());
    }
    
    public function edit($product_id) 
    {
        $record = Product::findOrFail($product_id); // type draft for this user
        
        $_model = $record;
        $action = route('catalog/product/update', ['product_id' => $product_id]); // todo
        $crud_product_description = route('crud.product.description', ['product_id' => $record->id]);
        
        $data = compact('action', 'crud_product_description', '_model');
        return view('catalog/product/form', $data);
    }
    
    public function update($product_id, Product $product, Request $request) 
    {
        $product->find($product_id)->update($request->all());
        
        return redirect(route('catalog/product'));
    }
    
    public function destroy($id) 
    {
        abort(404);
    }
}
