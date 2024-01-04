<?php

namespace LumenCart\Traits;

trait HasLanguages
{
    public function language()
    {
        $self = model_name(get_class($this));
        
        return $this->hasOne(model($self . '_language')->class)
        ->where('language_id', 1);
    }
    
    public function languages()
    {
        $self = model_name(get_class($this));

        return $this->hasMany(model($self . '_language')->class);
    }
}