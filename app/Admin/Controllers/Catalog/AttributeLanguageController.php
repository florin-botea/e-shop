<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Attribute;
use App\Models\Setting\Store;
use App\Models\Catalog\AttributeDescription;
use LumenCart\FormSession;

class AttributeLanguageController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $form_id = $request->route('attribute_id');
        list($attribute_id) = explode('-', $form_id);
        
        $this->model_catalog_attribute_language = app()->model('catalog/attribute_language');
        $this->form_attribute_language = new FormSession($form_id . '.languages', 'catalog/attribute_language', ['attribute_id' => $attribute_id]);
    }
    
    public function index($attribute_id) 
    {
        $form_id = $attribute_id;
        $collection = $this->form_attribute_language->all();
        
        $data = compact(
            'form_id',
            'collection',
        );
        
        return view('catalog/attribute_language/index', $data);
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
    
    public function edit($attribute_id, $language_id) 
    {
        return $this->form($attribute_id, $language_id);
    }
    
    public function update($attribute_id, $language_id) 
    {
        $this->save($attribute_id);
        
        return ['success' => true];        
    }
    
    protected function form($attribute_id, $language_id = 0)
    {
        $form_id = $attribute_id;
        $_model = $this->model_catalog_attribute_language;
        // $params = ['attribute_id' => $attribute_id];
        if ($language_id) {
            $_model = $this->form_attribute_language->find($language_id);
            //$params['language_id'] = $language_id;
            //$params['_method'] = 'PUT';
        }

        // $action = route('admin/catalog/attribute/language', $params);
        $language_options = $this->languageOptions($language_id);
        
        $data = compact(
            '_model',
            // 'action',
            'language_options'
        );
        
        return view('catalog/attribute_language/form', $data);
    }
    
    public function destroy($attribute_id, $language_id) 
    {
        $this->request->needsConfirmation();
        
        $this->form_attribute_language->delete($language_id);
    }
    
    // todo trait
    protected function languageOptions($language_id = 0)
    {
        $siblings = $this->form_attribute_language
        ->where('id', '!=', $language_id);

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
        $this->model_catalog_attribute_language->validator($this->request->all())->validate();

        $record = $this->form_attribute_language->updateOrCreate([
            'language_id' => $this->request->language_id
        ], $this->request->all());

        return $record;
    }
}
   