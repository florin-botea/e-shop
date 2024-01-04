<?php

namespace App\View\Fields;

use App\View\FieldInterface;

class MultilangText implements FieldInterface
{
    public static function getValue($model)
    {
        return $model->languages->pluck([], 'language_id');
    }

    public function configForm($data)
    {return ''; // todo:
        return view('fields/setup/numeric', $data);
    }

    public function input($data)
    {
        $data['type'] = 'text';

        return view('components/form/input-multilang', $data);
    }

    public function field($view)
    {
        $view['type'] = 'multilang'; // TODO: standard 21:31 4.1.2024

        return view('components/form/form-group', $view);
    }
}