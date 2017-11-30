<?php

return [
    'fields' => [
        'target' => 'Target',
        'relation' => 'Relation',
        'is_private' => 'Private',
        'two_way' => 'Create mirror relation',
    ],
    'placeholders' => [
        'target' => 'Choose an entity',
        'relation' => 'Nature of the relation',
    ],
    'hints' => [
        'is_private' => 'Hide from "Viewers"',
        'two_way' => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
    ],
    'create' => [
        'success' => 'Relation added for :name.',
        'title' => 'Create relations',
    ],
    'edit' => [
        'success' => 'Relation updated for :name.',
        'title' => 'Update relations',
    ],
    'destroy' => [
        'success' => 'Relation removed for :name.',
    ]
];
