<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use LumenCart\Traits\HasLanguages;

class Attribute extends Model
{
    use HasFactory, HasLanguages;
    
    protected $fillable = [
        'code',
        'unit_field',
        'config',
        'sort_order',
    ];
    
    protected $casts = [
        'config' => 'array',
    ];

    public function validator($data = [], $id = 0)
    {
        return Validator::make($data, [
            'code' => 'required|min:3|unique:attributes,code,' . $id . ',id',
        ]);
    }
    
    public function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return (array)$this->config;
        }
        
        return Arr::get($this->config, $key, $default);
    }
}
