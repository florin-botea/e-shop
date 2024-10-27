<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class BlockLanguage extends Model
{
    protected $fillable = [
        'module',
        'block',
        'code',
        'lang',
        'text',
    ];
}