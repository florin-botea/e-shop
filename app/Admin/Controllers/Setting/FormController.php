<?php

namespace App\Admin\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Store;

class FormController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
   
    public function index() 
    {
        $data['collection'] = model('setting/form')
        ->paginate();

        return view('setting/form/index', $data);
    }
    
    public function create() 
    {
        return $this->form();
    }
    
    public function store() 
    {
        $create = $this->request->all();
        model('setting/form')->validator($create)
        ->validate();
        
        $form = model('setting/form')->createWithRelationships($create);
        
        return redirect(route('admin/setting/form/edit', ['form_id' => $form->id]));
    }
    
    public function edit($form_id) 
    {
        return $this->form($form_id);
    }
    
    protected function form($form_id = 0)
    {
        $view['_model'] = model('setting/form');
        if ($form_id) {
            $view['_model'] = $view['_model']->findOrFail($form_id);
        }
        
        return view('setting/form/form', $view);
    }
}