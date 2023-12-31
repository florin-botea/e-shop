<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;
use LumenCart\Traits\HasLanguages;

class AttributeGroup extends Model
{
    use HasFactory, HasLanguages;
    
    protected $fillable = [
        'code',
        'sort_order',
    ];
    
    protected $validationRules = [
        'code' => 'required'
    ];
}
