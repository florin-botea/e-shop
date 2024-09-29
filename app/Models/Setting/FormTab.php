<?php

namespace App\Models\Setting;

use LumenCart\Model;
use LumenCart\Traits\HasLanguages;

class FormTab extends Model
{
    use HasLanguages;
    
    protected $fillable = [
        'form_id',
        'code',
    ];
}
