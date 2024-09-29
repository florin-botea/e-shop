<?php

namespace App\Models\Setting;

use LumenCart\Model;

class FormTabLanguage extends Model
{
    protected $fillable = [
        'form_tab_id',
        'language_id',
        'name',
    ];
}
