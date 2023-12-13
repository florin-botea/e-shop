<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LumenCart\Model;

class AttributeGroup extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'sort_order',
    ];
    
    protected $validationRules = [
        'code' => 'required'
    ];
    
    public function descriptions() {
        return $this->hasMany(model('catalog/attribute_group_description')->class);
    }
    
    public function scopeWithDescription($query)
    {
        return $query->join('attribute_group_descriptions as agd', function($j) {
            $j->on('agd.attribute_group_id', '=', 'attribute_groups.id');
            $j->on('agd.language_id', '=', \DB::raw(1));
        });
    }    
}
