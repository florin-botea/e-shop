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
        'field',
        'sort_order',
    ];
    
    protected $casts = [
        'field' => 'array',
    ];

    public function validator($data = [], $id = 0)
    {
        return Validator::make($data, [
            'code' => 'required|min:3|unique:attributes,code,' . $id . ',id',
        ]);
    }
    
    public function getFieldAttribute($field)
    {
        if (is_string($field)) {
            $field = json_decode($field, true);
        }
        
        if (empty($field['type'])) {
            $field['type'] = 'App\View\Fields\Text';
        }
        
        if (empty($field['settings'])) {
            $field['settings'] = [];
        }
        
        return $field;
    }
}
