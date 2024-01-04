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
        ->with('language')
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
        // TODO:
        $update = $this->request->all();
        // form('attribute_form', $update)->validate(); // TODO: standard 22:00 4.01.2024

        $attribute = model('catalog/attribute')->findOrFail($attribute_id);
        $attribute->updateWithRelationships($update);

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
        // TODO: standard 21:09 4.01.2024
        $attribute = model('catalog/attribute');
        if ($attribute_id) {
            $attribute = $attribute->findOrFail($attribute_id);
        }

        $view['_model'] = $attribute;
        $view['form'] = form('attribute_form', $attribute);

        return view('catalog/attribute/form', $view);
    }
}