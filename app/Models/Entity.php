<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'table_id',
    ];
}
