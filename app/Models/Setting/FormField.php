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
        'config',
        'sort_order',     
    ];
    
    protected $casts = [
        'config' => 'array',
    ];
}
