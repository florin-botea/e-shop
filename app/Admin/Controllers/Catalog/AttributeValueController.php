<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Manufacturer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use LumenCart\FormSession;
use App\View\Fields\Text;

class AttributeValueController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_catalog_attribute = app()->model('catalog/attribute');
        $this->model_catalog_attribute_value = app()->model('catalog/attribute_value');
    }
    
    public function index($attribute_id) 
    {
        $data['collection'] = $this->model_catalog_attribute_value
        ->where('attribute_id', $attribute_id)
        ->paginate();

        return view('catalog/attribute_value/index', $data);
    }
    
    public function show($id) 
    {
        abort(404);
    }
    
    public function create($attribute_id) 
    {
        return $this->form($attribute_id);
    }
    
    public function store($attribute_id) 
    {
        $this->model_catalog_attribute_value->validator($this->request->all())
        ->validate();
        
        $data = $this->request->all();
        $data = array_merge([
            'attribute_id' => $attribute_id,
            'value' => '',
            'unit' => '',
        ], $data);

        $record = $this->model_catalog_attribute_value->create($data);
        
        return ['success' => true];
    }
    
    public function edit($attribute_id, $value_id) 
    {
        return $this->form($attribute_id, $value_id);
    }
    
    public function update($attribute_id, $value_id) 
    {
        $this->model_catalog_attribute_value->validator($this->request->all(), $value_id)
        ->validate();

        $record = $this->model_catalog_attribute_value->findOrFail($attribute_id);
        $record->update($this->request->all()); 
        
        return redirect(route('admin/catalog/attribute_value'));
    }
    
    public function destroy($id) 
    {
        // todo validate
    }
    
    protected function form($attribute_id, $attribute_value_id = 0)
    {
        $attribute = $this->model_catalog_attribute->with('description')
        ->findOrFail($attribute_id);
        
        $record = $this->model_catalog_attribute_value;
        if ($attribute_value_id) {
            $record = $this->model_catalog_attribute_value->findOrFail($attribute_value_id);
        }
        
        $value = $record->value;
        if (!empty($attribute->config['value']['multilang'])) {
            $value = $record->descriptions()->get()->pluck([], 'language_id');
        }

        $label = $attribute->description->name;

        $value_field_data = array_merge($attribute->config['value'] ?? [], [
            'name' => 'value',
            'placeholder' => $attribute->description->name,
            'value' => $value
        ]);
        
        $unit_field_data = array_merge($attribute->config['unit'] ?? [], [
            'name' => 'unit',
            'value' => $record->unit
        ]);
        
        $fields = app('fields');
        $value_field = $fields->input(Text::class, $value_field_data);
        $unit_field = $fields->input($attribute->unit_field, $unit_field_data);

        $_model = $record;

        $data = compact(
            '_model',
            'label',
            'value_field',
            'unit_field',
        );
        
        return view('catalog/attribute_value/form', $data);
    }
}