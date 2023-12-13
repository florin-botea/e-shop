<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'store_id',
        'code',
        'key',
        'value',
        'is_json'
    ];
}
