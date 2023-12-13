<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
    
    public function validator($data = [], $id = 0)
    {
        return Validator::make($data, [
            'model' => 'required|min:3|unique:product,model,' . $id . ',id',
            'price' => 'required|numeric|min:0'
        ]);
    }
    
    public function drafts(): MorphMany
    {
        return $this->morphMany(\App\Admin\Models\User\UserDraft::class, 'draftable');
    }
}