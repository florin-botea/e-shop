<?php

namespace LumenCart\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'product';
    
    public function descriptions() 
    {
        return $this->hasMany(ProductDescription::class);
    }
}
