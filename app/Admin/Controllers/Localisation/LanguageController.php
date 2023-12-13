<?php

namespace App\Admin\Controllers\Localisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Localisation\Language;

class LanguageController extends Controller
{
    protected $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function index(Language $Language)
    {
        $data['collection'] = $Language->paginate();

        return view('localisation/language/index', $data);
    }
    
    public function create(Language $Language)
    {
        $data['_model'] = $Language;

        return view('localisation/language/form', $data);
    }
    
    public function store(Language $Language)
    {
        $Language->validator($this->request->all())
        ->validate();
        
        $record = $Language->create($this->request->all());
        
        return redirect(route('admin/localisation/language'));
    }
    
    public function edit($language_id, Language $Language)
    {
        $data['_model'] = $Language->findOrFail($language_id);

        return view('localisation/language/form', $data);
    }
    
    public function update($language_id, Language $Language)
    {
        $Language->validator($this->request->all())
        ->validate();
        
        $record = $Language->findOrFail($language_id);
        $record->update($this->request->all());
        
        return redirect(route('admin/localisation/language'));
    }
    
    public function destroy($language_id, Language $Language)
    {
        $this->request->needsConfirmation();
        // todo: complex check here
        
        $record = $Language->findOrFail($language_id);
        $record->delete();
        
        return [
            'success' => true
        ];
    }
}