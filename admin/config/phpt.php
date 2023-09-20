<?php

return [
    'src_path' => resource_path('views'),
    'cache_path' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),
    'debug' => false,
    'aliases' => [
        'x-form' => 'components/form/form',
        'x-csrf' => 'components/form/csrf',
        'x-btn-add' => 'components/buttons/btn-add',
        'x-btn-save' => 'components/buttons/btn-save',
        'x-btn-edit' => 'components/buttons/btn-edit',
        'x-btn-delete' => 'components/buttons/btn-delete',
        'x-modal' => 'components/modal',
        'x-tabs' => 'components/tabs',
        'x-tab-item' => 'components/tab-item',
        'x-crud' => 'components/crud',
        'x-index' => 'components/index',
        'x-input' => 'components/form/input',
        'x-form-group' => 'components/form/form-group',
        'x-form-check' => 'components/form/form-check',
    ],
];