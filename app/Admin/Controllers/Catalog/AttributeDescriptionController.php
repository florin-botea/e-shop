<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Attribute;
use App\Models\Setting\Store;
use App\Models\Catalog\AttributeDescription;
use LumenCart\FormSession;

class AttributeDescriptionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $form_id = $request->route('attribute_id');
        list($attribute_id) = explode('-', $form_id);
        
        $this->model_catalog_attribute_description = app()->model('catalog/attribute_description');
        $this->form_attribute_description = new FormSession($form_id . '.descriptions', 'catalog/attribute_description', ['attribute_id' => $attribute_id]);
    }
    
    public function index($attribute_id) 
    {
        $form_id = $attribute_id;
        $collection = $this->form_attribute_description->all();
        
        $data = compact(
            'form_id',
            'collection',
        );
        
        return view('catalog/attribute_description/index', $data);
    }
    
    public function create($attribute_id) 
    {
        return $this->form($attribute_id);
    }
    
    public function store($attribute_id) 
    {
        $this->save($attribute_id);

        return ['success' => true];
    }
    
    public function edit($attribute_id, $description_id) 
    {
        return $this->form($attribute_id, $description_id);
    }
    
    public function update($attribute_id, $description_id) 
    {
        $this->save($attribute_id);
        
        return ['success' => true];        
    }
    
    protected function form($attribute_id, $description_id = 0)
    {
        $form_id = $attribute_id;
        $_model = $this->model_catalog_attribute_description;
        $params = ['attribute_id' => $attribute_id];
        if ($description_id) {
            $_model = $this->form_attribute_description->find($description_id);
            $params['description_id'] = $description_id;
            $params['_method'] = 'PUT';
        }

        $action = route('admin/catalog/attribute/description', $params);
        $language_options = $this->languageOptions($description_id);
        
        $data = compact(
            '_model',
            'action',
            'language_options'
        );
        
        return view('catalog/attribute_description/form', $data);
    }
    
    public function destroy($attribute_id, $description_id) 
    {
        $this->request->needsConfirmation();
        
        $this->form_attribute_description->delete($description_id);
    }
    
    // todo trait
    protected function languageOptions($description_id = 0)
    {
        $siblings = $this->form_attribute_description
        ->where('id', '!=', $description_id);

        $used_language_ids = $siblings->pluck('language_id')->toArray();
        
        $language_options = [];
        foreach (app('languages') as $language) {
            $language_options[] = [
                'label' => $language->name,
                'value' => $language->id,
                'disabled' => in_array($language->id, $used_language_ids) ? true : null,
            ];            
        }
        
        return $language_options;
    }
    
    protected function save($attribute_id)
    {
        $this->model_catalog_attribute_description->validator($this->request->all())->validate();

        $record = $this->form_attribute_description->updateOrCreate([
            'language_id' => $this->request->language_id
        ], $this->request->all());

        return $record;
    }
}
   