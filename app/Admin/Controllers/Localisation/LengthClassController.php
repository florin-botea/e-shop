<?php

namespace App\Admin\Controllers\Localisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Localisation\Language;

class LengthClassController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_localisation_length_class = model('localisation/length_class');
    }
    
    public function index()
    {
        $data['collection'] = $this->model_localisation_length_class->paginate();

        return view('localisation/length_class/index', $data);
    }
    
    public function create()
    {
        $data['_model'] = $this->model_localisation_length_class;

        return view('localisation/length_class/form', $data);
    }
    
    public function store()
    {
        $this->model_localisation_length_class->validator($this->request->all())
        ->validate();
        
        $record = $this->model_localisation_length_class->create($this->request->all());
        
        return redirect(route('admin/localisation/length_class'));
    }
    
    public function edit($length_class_id)
    {
        $data['_model'] = $this->model_localisation_length_class->findOrFail($length_class_id);

        return view('localisation/length_class/form', $data);
    }
    
    public function update($length_class_id, Language $Language)
    {
        $this->model_localisation_length_class->validator($this->request->all())
        ->validate();
        
        $record = $this->model_localisation_length_class->findOrFail($length_class_id);
        $record->update($this->request->all());
        
        return redirect(route('admin/localisation/length_class'));
    }
    
    public function destroy($length_class_id, Language $Language)
    {
        $this->request->needsConfirmation();
        // todo: complex check here
        
        $record = $this->model_localisation_length_class->findOrFail($length_class_id);
        $record->delete();
        
        return [
            'success' => true
        ];
    }
}