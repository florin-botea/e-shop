<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Manufacturer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ManufacturerController extends Controller
{
    public function __construct(Request $request)
    {
        $this->model_catalog_manufacturer = app()->model('catalog/manufacturer');
    }
    
    public function index() 
    {
        $data['collection'] = $this->model_catalog_manufacturer
        ->withDescription()
        ->paginate();

        return view('catalog/manufacturer/index', $data);
    }
    
    public function show($id) 
    {
        abort(404);
    }
    
    public function create() 
    {
        $record = $this->model_catalog_manufacturer->new();
        $record->name = '';
        $record->save();
        
        return redirect(route('admin/catalog/manufacturer/edit', ['manufacturer_id' => $record->id]));
    }
    
    public function edit($manufacturer_id) 
    {
        $record = $this->model_catalog_manufacturer->findOrFail($manufacturer_id);
        
        $_model = $record;

        $data = compact('_model');
        
        return view('catalog/manufacturer/form', $data);
    }
    
    public function update($manufacturer_id) 
    {
        $this->model_catalog_manufacturer->validator($this->request->all())
        ->validate();

        $this->model_catalog_manufacturer->find($manufacturer_id)
        ->update($request->all());
        
        return redirect(route('catalog/manufacturer'));
    }
    
    public function destroy($id) 
    {
        // todo validate
    }
}