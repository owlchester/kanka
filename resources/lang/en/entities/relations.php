<?php

return [
    'create'        => [
        'success'   => 'Relation :target added to :entity.',
        'title'     => 'New relation for :name',
    ],
    'destroy'       => [
        'success'   => 'Relation :target removed for :entity.',
    ],
    'fields'        => [
        'attitude'  => 'Attitude',
        'is_star'   => 'Pinned',
        'relation'  => 'Relation',
        'target'    => 'Target',
        'two_way'   => 'Create mirror relation',
    ],
    'helper'        => 'Set up relations between entities with attitudes and visibility. Relations can also be pinned to the entitiy\'s menu.',
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
    'show'          => [
        'title' => 'Relations for :name',
    ],
    'update'        => [
        'success'   => 'Relation :target updated for :entity.',
        'title'     => 'Update relations for :name',
    ],
];
