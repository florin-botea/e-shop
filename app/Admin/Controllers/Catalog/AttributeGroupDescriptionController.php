<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Attribute;
use App\Models\Setting\Store;
use App\Models\Catalog\AttributeDescription;
use LumenCart\FormSession;

class AttributeGroupDescriptionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $form_id = $request->route('attribute_group_id');
        list($attribute_group_id) = explode('-', $form_id);
        
        $this->model_catalog_attribute_group_description = app()->model('catalog/attribute_group_description');
        $this->form_attribute_group_description = new FormSession($form_id . '.descriptions', 'catalog/attribute_group_description', ['attribute_group_id' => $attribute_group_id]);
    }
    
    public function index($attribute_group_id) 
    {
        $form_id = $attribute_group_id;
        $collection = $this->form_attribute_group_description->all();
        
        $data = compact(
            'form_id',
            'collection',
        );
        
        return view('catalog/attribute_group_description/index', $data);
    }
    
    public function create($attribute_group_id) 
    {
        return $this->form($attribute_group_id);
    }
    
    public function store($attribute_group_id) 
    {
        $this->save($attribute_group_id);

        return ['success' => true];
    }
    
    public function edit($attribute_group_id, $description_id) 
    {
        return $this->form($attribute_group_id, $description_id);
    }
    
    public function update($attribute_group_id, $description_id) 
    {
        $this->save($attribute_group_id);
        
        return ['success' => true];        
    }
    
    protected function form($attribute_group_id, $description_id = 0)
    {
        $form_id = $attribute_group_id;
        $_model = $this->model_catalog_attribute_group_description;
        $params = ['attribute_group_id' => $attribute_group_id];
        if ($description_id) {
            $_model = $this->form_attribute_group_description->find($description_id);
            $params['description_id'] = $description_id;
            $params['_method'] = 'PUT';
        }
        $action = route('admin/catalog/attribute_group/description', $params);

        $language_options = $this->languageOptions($description_id);
        
        $data = compact(
            '_model',
            'action',
            'language_options'
        );
        
        return view('catalog/attribute_group_description/form', $data);
    }
    
    public function destroy($attribute_group_id, $description_id) 
    {
        $this->request->needsConfirmation();
        
        $this->form_attribute_group_description->delete($description_id);
    }
    
    // todo trait
    protected function languageOptions($description_id = 0)
    {
        $siblings = $this->form_attribute_group_description
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
    
    protected function save($attribute_group_id)
    {
        $this->model_catalog_attribute_group_description->validator($this->request->all())->validate();

        $record = $this->form_attribute_group_description->updateOrCreate([
            'language_id' => $this->request->language_id
        ], $this->request->all());

        return $record;
    }
}
   