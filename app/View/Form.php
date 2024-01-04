<?php

namespace App\View;

class Form implements \Stringable
{
    protected $code;
    protected $model;

    public function __construct($code, $model = [])
    {
        $this->code = $code;
        $this->model = $model;
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
            $data = $this->fieldData($field, $class);
            $fields[] = (new $class())->field($data);
        }

        return implode("\n", $fields);
    }

    private function fieldData($field, $class)
    {
        $data = [
            'name' => $field->name,
            'label' => $field->language->label,
            'helper' => $field->language->helper,
            'mention' => $field->language->mention,
            'placeholder' => $field->language->placeholder,
        ];

        if (method_exists($class, 'getValue')) {
            $data['value'] = $class::getValue($this->model);

        } else {
            $data['value'] = data_get($this->model, $field->name);
        }

        $data = array_merge($data, (array)$field->config);

        return $data;
    }
}