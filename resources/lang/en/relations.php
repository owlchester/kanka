<?php

return [
    'fields' => [
        'target' => 'Target',
        'relation' => 'Relation',
        'two_way' => 'Create mirror relation',
    ],
    'placeholders' => [
        'target' => 'Choose an entity',
        'relation' => 'Nature of the relation',
    ],
    'hints' => [
        'two_way' => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
    ],
    'create' => [
        'success' => 'Relation added for :name.',
        'title' => 'Create relations',
        'description' => '',
    ],
    'edit' => [
        'success' => 'Relation updated for :name.',
        'title' => 'Update relations',
        'description' => '',
    ],
    'destroy' => [
        'success' => 'Relation removed for :name.',
    ]
];
