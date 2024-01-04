<?php

namespace App\View;

class Form implements \Stringable
{
    protected $code;
    protected $data;
    
    public function __construct($code, $data = [])
    {
        $this->code = $code;
        $this->data = $data;
    }
    
    public function __toString()
    {
        $form = model('setting/form')
        ->with('fields.language')
        ->where('code', $this->code)
        ->first();

        if (!$form) return '';
        
        $fields = [];
        foreach ($form->fields as $field) {
            $class = $field->field;
            $language = $field->language;
            unset($field->language);
            $data = array_merge($field->toArray(), $language->toArray());
            //dump($data); todo: unsets
            $fields[] = (new $class())->field($data);
        }

        return implode("\n", $fields);
    }
}