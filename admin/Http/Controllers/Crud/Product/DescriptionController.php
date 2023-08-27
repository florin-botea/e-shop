<?php

namespace App\Http\Controllers\Crud\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Product;
use App\Models\Catalog\ProductDescription;

class DescriptionController extends Controller
{
    public function index($product_id) 
    {
// $x = require(base_path('../database/migrations/2023_02_17_181403_create_product_descriptions_table.php'));
// $x->down();
// $x->up();
        
        return view('crud/product/description/index');
    }
    
    public function create($product_id) 
    {
        $action = route('crud.product.description', ['product_id' => $product_id]);
        $method = 'POST';
        
        $data = compact('action', 'method');
   
        return view('crud/product/description/form', $data);
    }
    
    public function store($product_id, Request $request) 
    {
        $record = Product::find($product_id)->descriptions()->create($request->all());
        dd($record);
    }
}
    