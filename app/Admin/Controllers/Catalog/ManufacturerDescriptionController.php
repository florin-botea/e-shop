<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Manufacturer;
use App\Models\Setting\Store;
use App\Models\Catalog\ManufacturerDescription;

class ManufacturerDescriptionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        
        if (!$this->request->get('store_id')) {
            abort(404);
        }

        $this->model_catalog_manufacturer_description = app()->model('catalog/manufacturer_description');
        $this->model_setting_store = app()->model('setting/store');
        $this->store = $this->model_setting_store->findOrFail($this->request->get('store_id'));
    
    }
    public function index($manufacturer_id) 
    {
        $data['collection'] = $this->model_catalog_manufacturer_description->where('store_id', $this->store->id)
        ->paginate();
        
        $data['manufacturer_id'] = $manufacturer_id;
        $data['store_id'] = $this->store->id;
        
        return view('catalog/manufacturer_description/index', $data);
    }
    
    public function create($manufacturer_id) 
    {
        $data['action'] = route('admin/catalog/manufacturer/description', [
            'manufacturer_id' => $manufacturer_id, 
            'store_id' => $this->store->id
        ]);
        $data['language_options'] = $this->getLanguageOptions();

        return view('catalog/manufacturer_description/form', $data);
    }
    
    public function store($manufacturer_id) 
    {
        $this->model_catalog_manufacturer_description->validator($this->request->all())->validate();
        
        $record = $this->model_catalog_manufacturer_description->updateOrCreate([
            'language_id' => $this->request->language_id,
            'store_id' => $this->request->store_id
        ], $this->request->all());
        
        return ['success' => true];
    }
    
    public function edit($manufacturer_id, $description_id) 
    {
        $data['action'] = route('admin/catalog/manufacturer/description', [
            'manufacturer_id' => $manufacturer_id, 
            'description_id' => $description_id, 
            'store_id' => $this->store->id,
            '_method' => 'PUT'
        ]);
        $data['language_options'] = $this->getLanguageOptions($description_id);
        
        $data['_model'] = $this->model_catalog_manufacturer_description->findOrFail($description_id);

        return view('catalog/manufacturer_description/form', $data);        
    }
    
    public function update($manufacturer_id, $description_id) 
    {
        $this->model_catalog_manufacturer_description->validator($this->request->all())->validate();
        
        $record = $this->model_catalog_manufacturer_description->updateOrCreate([
            'language_id' => $this->request->language_id,
            'store_id' => $this->request->store_id
        ], $this->request->all());
        
        return ['success' => true];        
    }
    
    public function destroy($manufacturer_id, $description_id) 
    {
        $this->request->needsConfirmation();
        
        $this->model_catalog_manufacturer_description->findOrFail($description_id)
        ->delete();
    }
    
    // todo trait
    protected function getLanguageOptions($description_id = 0)
    {
        $store_config = $this->store->getSettings('store');
        $siblings = $this->model_catalog_manufacturer_description->where('store_id', $this->store->id)
        ->where('id', '!=', $description_id)
        ->get();

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
}
   