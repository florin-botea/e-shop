<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function index() {
        $resource = request('resource');
        $q = request('q');
        if ($resource && method_exists($this, $resource)) 
        {
            return $this->{$resource}($q);
        }
    }
    
    private function categories($q)
    {
        return [
            [
                'value' => 1,
                'label' => 'Foo'
            ],
            [
                'value' => 2,
                'label' => 'Foox'
            ]
        ];
    }
}
