<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function index(Product $product) 
    {
        $data['collection'] = $product->with('description')->paginate();

        return view('catalog/product/index', $data);
    }
    
    public function show($id) 
    {
        abort(404);
    }
    
    public function create(Product $Product) 
    {
// $x = require(base_path('../database/migrations/2023_02_17_175413_create_products_table.php'));
// $x->down();
// $x->up();
if (! Auth::check()) { // todo
    $user = \App\Admin\Models\User\User::firstOrCreate(['name' => 'test'], ['email' => 'test', 'password' => 'pw']);
    Auth::login($user);
}
  // todo
        $draft = Auth::user()->drafts()->where('draftable_type', Product::class)->first();
        $record = $Product->find($draft->draftable_id ?? 0);
        if (! $record) {
            $record = $Product->create(['status' => 0]);
            $record->drafts()->create(['user_id' => Auth::id()]);
        }
        
        return redirect(route('admin/catalog/product/edit', ['product_id' => $record->id]));
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
    
    public function update($product_id, Product $Product) 
    {
        $Product->validator($this->request->all())
        ->validate();

        $Product->find($product_id)
        ->update($request->all());
        
        return redirect(route('catalog/product'));
    }
    
    public function destroy($id) 
    {
        abort(404);
    }
}
