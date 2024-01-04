<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Manufacturer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use LumenCart\FormSession;

class AttributeGroupValueController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_catalog_attribute = app()->model('catalog/attribute');
        $this->model_catalog_attribute_group = app()->model('catalog/attribute_group');
        $this->model_catalog_attribute_group_value = app()->model('catalog/attribute_group_value');
    }
    
    public function index($attribute_group_id) 
    {
        $data['collection'] = $this->model_catalog_attribute_group_value
        ->with('attribute.language')
        ->where('attribute_group_id', $attribute_group_id)
        ->paginate();

        return view('catalog/attribute_group_value/index', $data);
    }
    
    public function show($id) 
    {
        abort(404);
    }
    
    public function create($attribute_group_id) 
    {
        return $this->form($attribute_group_id);
    }
    
    public function store($attribute_group_id) 
    {
        $this->model_catalog_attribute_group_value->validator($this->request->all())
        ->validate();
        
        $create = $this->request->all();
        $create['attribute_group_id'] = $attribute_group_id;
        $record = $this->model_catalog_attribute_group_value->createWithRelationships($create);
        
        return ['success' => true];
    }
    
    public function edit($attribute_group_id, $value_id) 
    {
        return $this->form($attribute_group_id, $value_id);
    }
    
    public function update($attribute_group_id) 
    {
        $this->model_catalog_attribute_group_value->validator($this->request->all(), $attribute_group_id)
        ->validate();

        $update = $this->request->all();
        $record = $this->model_catalog_attribute_group_value->findOrFail($attribute_group_id);
        $record->updateWithRelationships($update);
        
        return ['success' => true];
    }
    
    public function destroy($id) 
    {
        // todo validate
    }
    
    protected function form($attribute_group_id, $attribute_group_value_id = 0)
    {
        $record = $this->model_catalog_attribute_group_value;
        if ($attribute_group_value_id) {
            $record = $this->model_catalog_attribute_group_value->findOrFail($attribute_group_value_id);
        }
        
        $attributes = $this->model_catalog_attribute->with('language')->get();
        $siblings = $this->model_catalog_attribute_group_value->where('attribute_group_id', $attribute_group_id)
        ->where('attribute_id', '!=', $attribute_group_value_id)
        ->pluck('attribute_id')
        ->toArray();
        
        $attribute_options = [];
        foreach ($attributes as $attribute) {
            $attribute_options[] = [
                'label' => $attribute->language->name,
                'value' => $attribute->id,
                'disabled' => in_array($attribute->id, $siblings)
            ];
        }
        
        $_model = $record;

        $data = compact(
            '_model', 
            'attribute_options',
        );
        
        return view('catalog/attribute_group_value/form', $data);
    }
}