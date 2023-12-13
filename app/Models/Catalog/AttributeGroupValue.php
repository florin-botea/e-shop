<?php

namespace App\Models\Catalog;

use LumenCart\Model;

class AttributeGroupValue extends Model
{
    protected $fillable = [
        'attribute_group_id',
        'attribute_id',
        'sort_order',
    ];
    
    public function attribute() {
        return $this->belongsTo(model('catalog/attribute')->class);
    }
}
