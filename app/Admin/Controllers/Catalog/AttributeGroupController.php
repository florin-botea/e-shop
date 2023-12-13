<?php

namespace App\Admin\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog\Manufacturer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use LumenCart\FormSession;

class AttributeGroupController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_catalog_attribute_group = app()->model('catalog/attribute_group');
    }
    
    public function index() 
    {
        $data['collection'] = $this->model_catalog_attribute_group
        ->withDescription()
        ->paginate();

        return view('catalog/attribute_group/index', $data);
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
        $this->model_catalog_attribute_group->validator($this->request->all())
        ->validate();
        
        $record = $this->model_catalog_attribute_group->create($this->request->all());
        $relationships = FormSession::pull($this->request->_form_id);
        foreach ($relationships as $key => $collection) {
            foreach ($collection as $item) {
                $item->attribute_group_id = $record->id;
                $item->save();
            }
        }
        
        return redirect(route('admin/catalog/attribute_group'));
    }
    
    public function edit($attribute_group_id) 
    {
        return $this->form($attribute_group_id);
    }
    
    public function update($attribute_group_id) 
    {
        $this->model_catalog_attribute_group->validator($this->request->all(), $attribute_group_id)
        ->validate();

        $record = $this->model_catalog_attribute_group->findOrFail($attribute_group_id);
        $relationships = FormSession::pull($this->request->_form_id);
        foreach ($relationships as $relationship => $collection) {
            $record->{$relationship}()->whereNotIn('id', $collection->pluck('id')->toArray())
            ->delete();
            foreach ($collection as $item) {
                $item->attribute_group_id = $record->id;
                $item->save();
            }
        }
        
        return redirect(route('admin/catalog/attribute_group'));
    }
    
    public function destroy($id) 
    {
        // todo validate
    }
    
    protected function form($attribute_group_id = 0)
    {
        /** see #1 */
        $form_id = old('_form_id', $attribute_group_id . '-' . uniqid());
        
        $record = $this->model_catalog_attribute_group;
        if ($attribute_group_id) {
            $record = $this->model_catalog_attribute_group->findOrFail($attribute_group_id);
        }
        
        $_model = $record;

        $data = compact(
            'form_id',
            '_model'
        );
        
        return view('catalog/attribute_group/form', $data);
    }
}