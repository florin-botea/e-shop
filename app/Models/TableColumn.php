<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableColumn extends Model
{
    protected $fillable = [
        'table_id',
        'type',
        'name',
        'description',
        'default',
        'length',
        'index',
    ];
}
