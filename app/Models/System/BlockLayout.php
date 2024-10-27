<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class BlockLayout extends Model
{
    protected $fillable = [
      'code',
      'model',
      'data'
    ];
    
    protected $casts = [
      'data' => 'array'
    ];
}
