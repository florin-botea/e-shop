<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;

class AttributeGroupDescription extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'attribute_group_id',
        'language_id',
        'name',
    ];
    
    protected $validationRules = [
        'language_id' => 'required',
        'name' => 'required|min:3',
    ];
}
