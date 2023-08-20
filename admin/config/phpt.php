<?php

return [
    'src_path' => resource_path('views'),
    'cache_path' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
    'debug' => false,
    'aliases' => [
        'x-csrf' => 'components/form/csrf',
        'x-tabs' => 'components/tabs',
        'x-input' => 'components/form/input',
        'x-form-group' => 'components/form/form-group',
    ],
];