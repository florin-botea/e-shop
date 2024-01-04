<?php

namespace App\Models\Setting;

use LumenCart\Model;

class Form extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order');
    }
}
