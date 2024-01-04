<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Category;

class CategoryController extends Controller
{
    public function __construct(Request $request)
    {
        $this->model_catalog_category = app()->model('catalog/category');
    }
    
    public function index() 
    {
        $data['collection'] = $this->model_catalog_category
        ->with('description')
        ->paginate();

        return view('catalog/category/index', $data);
    }
    
    public function show($id) 
    {
        abort(404);
    }
    
    public function create() 
    {
        return $this->form();
    }
    
    public function store() 
    {
        $this->model_catalog_category->validator($this->request->all())
        ->validate();
  
        $create = $this->request->all();
        $record = $this->model_catalog_category->createWithRelationships($create);

        return redirect(route('admin/catalog/category'));
    }    
    
    public function edit($category_id) 
    {
        return $this->form($category_id);
    }
    
    public function update($category_id) 
    {
        $this->model_catalog_category->validator($this->request->all())
        ->validate();

        $update = $request->all();
        $this->model_catalog_category->find($category_id)
        ->update($update);
        
        return redirect(route('catalog/category'));
    }
    
    public function destroy($id) 
    {
        // todo validate
    }
    
    protected function form($category_id = 0)
    {
        $record = $this->model_catalog_category;
        if ($category_id) {
            $record = $this->model_catalog_category->findOrFail($category_id);
        } 
        
        $_model = $record;
        
        $data = compact(
            '_model', 
        );
        
        return view('catalog/category/form', $data);
    }
}