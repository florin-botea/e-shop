<?php

namespace LumenCart\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;
    
    protected $table = 'product_description';
    protected $fillable = [
        'product_id',
        'language_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'tags',
    ];
}
