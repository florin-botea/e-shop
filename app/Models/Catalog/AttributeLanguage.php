<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use LumenCart\Traits\IsLanguage;

class AttributeLanguage extends Model
{
    use HasFactory, IsLanguage;
    
    protected $fillable = [
        'attribute_id',
        'language_id',
        'name',
    ];
    
    protected $validationRules = [
        'language_id' => 'required',
        'name' => 'required|min:3',
    ];
}
