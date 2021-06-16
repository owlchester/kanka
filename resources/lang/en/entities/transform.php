<?php

return [
    'actions'       => [
        'transform' => 'Transform',
    ],
    'fields'        => [
        'target'        => 'New entity type',
        'select_one'    => 'Select one',
    ],
    'panel'         => [
        'title'         => 'Transform an entity',
        'description'   => 'Did you create this entity as one type but realised another type would suit it better? No worries, you can change the entity\'s type at any time. Please be aware that some data might be lost due to the different fields between entities.',
    ],
    'success'       => 'Entity \':name\' transformed.',
    'title'         => 'Transform :name',
];
