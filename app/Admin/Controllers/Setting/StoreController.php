<?php

namespace App\Admin\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Store;

class StoreController extends Controller
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function index(Store $Store)
    {
        $data['collection'] = $Store->paginate();

        return view('setting/store/index', $data);
    }
    
    public function create(Store $Store)
    {
        $data['_model'] = $Store;

        return view('setting/store/form', $data);
    }
    
    public function store(Store $Store)
    {
        $Store->validator($this->request->all())
        ->validate();
        
        $record = $Store->create($this->request->all());
        $record->saveSettings('store', $this->request->all());
        
        return redirect(route('admin/setting/store'));
    }
    
    public function edit($store_id, Store $Store)
    {
        $data['_model'] = $Store->findOrFail($store_id);
        $settings = $data['_model']->getSettings('store');
        foreach ($settings as $key => $value) {
            $data['_model'][$key] = $value;
        }

        return view('setting/store/form', $data);
    }
    
    public function update($store_id, Store $Store)
    {
        $Store->validator($this->request->all())
        ->validate();
        
        $record = $Store->findOrFail($store_id);
        $record->update($this->request->except('_method'));
        $record->saveSettings('store', $this->request->all());
        
        return redirect(route('admin/setting/store'));
    }
    
    public function destroy($store_id, Store $Store)
    {
        $this->request->needsConfirmation();
        // todo: complex check here
        
        $record = $Store->findOrFail($store_id);
        $record->delete();
        
        return [
            'success' => true
        ];
    }
}