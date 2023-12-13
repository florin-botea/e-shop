<?php

namespace LumenCart;

class AbstractModel 
{
    protected $name;
    protected $instance = null;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function __call($m, $args)
    {
        if (! $this->instance) {
            $this->instance = app()->make('model::' . $this->name);
        }
        
        return $this->instance->{$m}(...$args);
    }
    
    public function __get($prop) {
        if (! $this->instance) {
            $this->instance = app()->make('model::' . $this->name);
        }        
        
        $m = 'get' . ucfirst($prop);
        if (method_exists($this, $m)) {
            return $this->{$m}();
        }
        
        return $this->instance->$prop;
    }
    
    public function __set($prop, $val) {
        if (! $this->instance) {
            $this->instance = app()->make('model::' . $this->name);
        }        
        
        $this->instance->$prop = $val;
    }
    
    public function getClass(): string
    {
        if (! $this->instance) {
            $this->instance = app()->make('model::' . $this->name);
        }
        
        return get_class($this->instance);
    }
    
    public function new()
    {
        return app()->make('model::' . $this->name);
    }
    // todo get set callstatic
}