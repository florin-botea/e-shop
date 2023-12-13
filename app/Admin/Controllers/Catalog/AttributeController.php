<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Manufacturer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use LumenCart\FormSession;

class AttributeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_catalog_attribute = app()->model('catalog/attribute');
    }
    
    public function index() 
    {
        $data['collection'] = $this->model_catalog_attribute
        ->with('description')
        ->paginate();

        return view('catalog/attribute/index', $data);
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
        $this->model_catalog_attribute->validator($this->request->all())
        ->validate();
  
        $relationships = FormSession::pull($this->request->_form_id);
        $relationships = json_decode(json_encode($relationships), true);
        $create = array_merge($this->request->all(), $relationships);
        $record = $this->model_catalog_attribute->createWithRelationships($create);

        return redirect(route('admin/catalog/attribute'));
    }
    
    public function edit($attribute_id) 
    {
        return $this->form($attribute_id);
    }
    
    public function update($attribute_id) 
    {
        $this->model_catalog_attribute->validator($this->request->all(), $attribute_id)
        ->validate();

        $relationships = FormSession::pull($this->request->_form_id);
        $relationships = json_decode(json_encode($relationships), true);
        $update = array_merge($this->request->all(), $relationships);
        $record = $this->model_catalog_attribute->findOrFail($attribute_id);
        $record->updateWithRelationships($update);
        
        return redirect(route('admin/catalog/attribute'));
    }
    
    public function destroy($attribute_id) 
    {
        // todo validate
        $record = $this->model_catalog_attribute->findOrFail($attribute_id);
        $record->delete();
        
        return [
            'success' => true
        ];
    }
    
    protected function form($attribute_id = 0)
    {
        /** see #1 */
        $form_id = old('_form_id', $attribute_id . '-' . uniqid());

        $record = $this->model_catalog_attribute;
        if ($attribute_id) {
            $record = $this->model_catalog_attribute->findOrFail($attribute_id);
        } 
        
        $fields = app('fields');
        $unit_field_setup = null;

        $_model = $record;
        $field_type_options = $fields->toSelectOptions();
        
        $value_field_config = $unit_field_config = null;
        if ($attribute_id) {
        $value_field_config = $fields->configForm('text', 
            array_merge($record->config['value_field'] ?? [], ['name' => 'config.value_field']));
        $unit_field_config = $fields->configForm($record->unit_field, 
            array_merge($record->config['unit_field'] ?? [], ['name' => 'config.unit_field']));
        }

        $data = compact(
            'form_id',
            '_model', 
            'field_type_options', 
            'value_field_config',
            'unit_field_config',
        );
        
         view('catalog/attribute/form', $data);
        return view('catalog/attribute/form', $data);
    }
}