<?php

return [
    [
        'name' => 'Translation',
        'flag' => 'translations.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'translations.create',
        'parent_flag' => 'translations.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'translations.edit',
        'parent_flag' => 'translations.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'translations.destroy',
        'parent_flag' => 'translations.index',
    ],
];