<?php

namespace LumenCart;

class AbstractModel extends Model
{
    protected $fillable = [];
    
    public function addFillable($fillable)
    {
        $this->fillable = array_merge($this->fillable, (array)$fillable);
    }
}