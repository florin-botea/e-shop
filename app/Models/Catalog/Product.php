<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use LumenCart\Traits\HasLanguages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory, HasLanguages;

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
    
    public function validator($data = [], $id = 0)
    {
        return Validator::make($data, [
            'model' => 'required|min:3|unique:product,model,' . $id . ',id',
            'price' => 'required|numeric|min:0'
        ]);
    }
}