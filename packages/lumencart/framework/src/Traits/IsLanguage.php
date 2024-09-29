<?php

namespace LumenCart\Traits;

trait IsLanguage
{
    public function siblingsLanguages()
    {
        $self = model_name(get_class($this));
        $name_parts = explode('/', $self);
        $key = str_replace('_language', '_id', end($name_parts));
                
        return $this->where($key, $this->{$key})
        ->where('language_id', '!=', $this->language_id)
        ->get();
    }
}