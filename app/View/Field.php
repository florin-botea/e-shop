<?php

namespace App\View;

class Field
{
    protected $fields = [];

    public function __construct() {
        $preset = get_dir_classes(base_path('app/View/Fields'), 'App\\View\\Fields');

        foreach ($preset as $preset) {
            if (class_exists($preset) && isset(class_implements($preset)['App\\View\\FieldInterface'])) {
                $this->fields[] = $preset;
            }
        }
    }

    public function add(string $class) {
        if (!class_exists($class)) {
            throw new \Exception("Class $class not found");
        }
        
        if (!isset(class_implements($preset)['App\\View\\FieldInterface'])) {
            throw new \Exception("Field Class $class must implement FieldInterface");
        }
        
        $this->fields[] = $preset;
    }
    
    public function toSelectOptions()
    {
        return array_map(fn($class) => [
            'label' => class_basename($class),
            'value' => $class
        ], $this->fields);
    }
    
    public function make(string $field, $settings = [], $value = null) 
    {
        if (in_array($field, $this->fields)) {
            return new $field($settings, $value);
        }
    }
    
    public function configForm($type, $data = []) 
    {
        $field = $this->make($type);
        
        if (! $field) {
            return;
        }
        
        return $field->configForm($data);
    }
    
    public function input($type, $data = []) 
    {
        $field = $this->make($type);
        
        if (! $field) {
            if ($type) {
                throw new \Exception("Field $type not found");
            }
            return;
        }  
        
        return $field->input($data);
    }
    
    public function validationForm()
    {
        return view('fields/setup/validation');
    }
}