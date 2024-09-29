<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use LumenCart\Traits\IsLanguage;

class CategoryLanguage extends Model
{
    use HasFactory, IsLanguage;
    
    protected $fillable = [
        'category_id',
        'language_id',
        'name',
        'description'
    ];
}
