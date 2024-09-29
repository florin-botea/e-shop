<?php

namespace App\Models\Setting;

use LumenCart\Model;
use LumenCart\Traits\HasLanguages;

class FormField extends Model
{
    use HasLanguages;
    
    protected $fillable = [
        'form_id',
        'name',
        'field',
        'sort_order',     
    ];
    
    protected $casts = [
        'field' => 'array',
    ];
    
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
