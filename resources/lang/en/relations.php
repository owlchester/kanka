<?php

return [
    'create'        => [
        'description'   => 'Create a new relation',
        'success'       => 'Relation added for :name.',
        'title'         => 'Create relations',
    ],
    'destroy'       => [
        'success'   => 'Relation removed for :name.',
    ],
    'edit'          => [
        'success'   => 'Relation updated for :name.',
        'title'     => 'Update relations',
    ],
    'fields'        => [
        'attitude'  => 'Attitude',
        'is_star'   => 'Pinned',
        'relation'  => 'Relation',
        'target'    => 'Target',
        'two_way'   => 'Create mirror relation',
    ],
    'hints'         => [
        'mirrored'  => [
            'text'  => 'This relation is mirrored with :link.',
            'title' => 'Mirrored',
        ],
        'two_way'   => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 to 100, 100 being very positive.',
        'relation'  => 'Nature of the relation',
        'target'    => 'Choose an entity',
    ],
];
