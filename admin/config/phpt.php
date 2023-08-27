<?php

return [
    'src_path' => resource_path('views'),
    'cache_path' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
    'debug' => false,
    'aliases' => [
        'x-form' => 'components/form/form',
        'x-csrf' => 'components/form/csrf',
        'x-btn-save' => 'components/buttons/btn-save',
        'x-modal' => 'components/modal',
        'x-tabs' => 'components/tabs',
        'x-crud' => 'components/crud',
        'x-input' => 'components/form/input',
        'x-form-group' => 'components/form/form-group',
    ],
];