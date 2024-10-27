<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityProperty extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'entity_id',
        'name',
        'code',
        'type',
        'default',
        'length',
        'index',
    ];
}
