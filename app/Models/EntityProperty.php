<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityProperty extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'entity_id',
        'table_column_id',
        'code',
    ];
}
