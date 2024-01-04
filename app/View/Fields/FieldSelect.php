<?php

namespace App\View\Fields;

use App\View\FieldInterface;

class FieldSelect implements FieldInterface
{
    public function configForm($data)
    {
        return view('fields/setup/field_select', $data);
    }

    public function input($data)
    {
        $fields = app('fields');
        $view['options'] = $fields->toSelectOptions();

        return view('fields/field_select', $view);
    }

    public function field($view)
    {
        $fields = app('fields');
        $view['options'] = $fields->toSelectOptions();

        if (!empty($view['nullable'])) {
            $view['blank'] = '- None -';
        }

        return view('fields/field_select', $view);
    }
}