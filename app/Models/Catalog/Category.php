<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use LumenCart\Traits\HasLanguages;

class Category extends Model
{
    use HasFactory, HasLanguages;
    
    protected $fillable = [
        'code'
    ];
}
