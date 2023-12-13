<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class Attribute extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'unit_field',
        'config',
        'sort_order',
    ];
    
    protected $casts = [
        'config' => 'array',
    ];
    
    public function descriptions() {
        return $this->hasMany(model('catalog/attribute_description')->class);
    }
    
    public function description() {
        return $this->hasOne(model('catalog/attribute_description')->class);
    }

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
