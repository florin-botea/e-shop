<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;

class AttributeValue extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'attribute_id',
        'value',
        'unit',
        'value_lang',
        'unit_lang'
    ];
 
    protected $validationRules = [
        'value' => 'required',
    ]; 
    
    public function scopeWithDescription($query) {
        $query->leftJoin('attribute_value_descriptions as avd', function($j) {
            $j->on('avd.attribute_value_id', '=', 'attribute_values.id');
            $j->on('avd.language_id', '=', \DB::raw(1));
        });
    }
}
