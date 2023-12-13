<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Product;
use App\Models\Catalog\ProductDescription;

class ProductDescriptionController extends Controller
{
    public function index($product_id) 
    {
// $x = require(base_path('../database/migrations/2023_02_17_181403_create_product_descriptions_table.php'));
// $x->down();
// $x->up();
        $_model = Product::find($product_id);
        $collection = ProductDescription::where('product_id', $product_id)->get();
        
        $data = compact('collection', '_model');
        
        return view('catalog/product_description/index', $data);
    }
    
    public function create($product_id) 
    {
        $action = route('catalog.product.description', ['product_id' => $product_id]);
        
        $data = compact('action');
   
        return view('catalog/product_description/form', $data);
    }
    
    public function store($product_id, Request $request) 
    {
        $record = Product::find($product_id)->descriptions()->create($request->all());
    }
    
    public function edit($product_id, $description_id) 
    {
        $action = route('catalog.product.description', ['product_id' => $product_id, 'description_id' => $description_id, '_method' => 'PUT']);
        $_model = ProductDescription::find($description_id);

        $data = compact('_model', 'action');
   
        return view('catalog/product_description/form', $data);        
    }
    
    public function update($product_id, $description_id, ProductDescription $Description) 
    {
        $Description->find($description_id)->update($this->request->all());
        
    }
    
    public function destroy($product_id, $description_id, ProductDescription $Description) 
    {
        $this->request->needsConfirmation();
        
        $Description->find($description_id)->delete();
    }
}
    