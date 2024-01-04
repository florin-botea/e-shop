<?php

namespace App\Models\Setting;

use LumenCart\Model;

class FormFieldLanguage extends Model
{
    protected $fillable = [
        'form_field_id',
        'language_id',
        'label',
        'helper',
        'mention',
        'placeholder',
    ];
}