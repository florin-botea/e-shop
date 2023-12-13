<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ManufacturerDescription extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'store_id',
        'language_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'tags',
    ];
    
    public function validator($data = [], $id = 0)
    {
        return Validator::make($data, [
            'name' => 'required|min:3|unique:manufacturers,name,' . $id . ',id',
        ]);
    }
}
