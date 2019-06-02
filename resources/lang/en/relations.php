<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Relation added for :name.',
        'title'         => 'Create relation for :name',
    ],
    'destroy'       => [
        'success'   => 'Relation removed for :name.',
    ],
    'edit'          => [
        'success'   => 'Relation updated for :name.',
        'title'     => 'Update relation for :name',
    ],
    'fields'        => [
        'relation'  => 'Relation',
        'target'    => 'Target',
        'two_way'   => 'Create mirror relation',
    ],
    'hints'         => [
        'two_way'   => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
    ],
    'placeholders'  => [
        'relation'  => 'Nature of the relation',
        'target'    => 'Choose an entity',
    ],
];
