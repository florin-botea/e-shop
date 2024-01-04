<?php

namespace App\Admin\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Store;

class FormFieldController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
   
    public function index() 
    {
        $data['collection'] = model('setting/form_field')
        ->paginate();

        return view('setting/form_field/index', $data);
    }
    
    public function create($form_id) 
    {
        return $this->form($form_id);
    }
    
    public function store() 
    {
        $create = $this->request->all();
        model('setting/form_field')->validator($create)
        ->validate();
        
        $form_field = model('setting/form_field')->createWithRelationships($create);
        
        return ['success' => true];
    }
    
    public function edit($form_id, $field_id) 
    {
        return $this->form($form_id, $field_id);
    }
    
    public function update($form_id, $field_id) 
    {
        $update = $this->request->all();
        model('setting/form_field')->validator($update)
        ->validate();

        $form_field = model('setting/form_field')->findOrFail($field_id)
        ->updateWithRelationships($update);
        
        return ['success' => true];        
    }
    
    public function destroy($form_id, $field_id) 
    {
        $this->request->needsConfirmation();
        
        $form_field = model('setting/form_field')->findOrFail($field_id)
        ->delete();
        
        return ['success' => true];        
    }
    
    protected function form($form_id, $field_id = 0)
    {
        $view['_model'] = model('setting/form_field');
        if ($field_id) {
            $view['_model'] = $view['_model']->findOrFail($field_id);
        }
        
        $fields = app('fields');
        $view['field_type_options'] = $fields->toSelectOptions();
        
        if ($field_id) {
            $view['field_config'] = $fields->configForm($view['_model']->field, 
                array_merge($view['_model']->config ?? [], ['name' => 'config']));
        }
        
        return view('setting/form_field/form', $view);
    }
}