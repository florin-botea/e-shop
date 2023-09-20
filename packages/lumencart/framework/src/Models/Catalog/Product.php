<?php

namespace LumenCart\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'product';
    
    protected $fillable = [
        'model',      
        'sku',
        'upc',
        'ean',
        'jan',
        'isbn',
        'mpn',
        'shipping',
    ];
    
    public function description()
    {// todo where lang id
        return $this->hasOne(ProductDescription::class);
    }
    
    public function descriptions() 
    {// todo, get_class(app->make(ProductDescription))
        return $this->hasMany(ProductDescription::class);
    }
}
