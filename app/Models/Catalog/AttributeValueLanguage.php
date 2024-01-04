<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;

class AttributeValueLanguage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'attribute_value_id',
        'language_id',
        'name',
    ];
}
