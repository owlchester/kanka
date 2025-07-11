<?php

return [
    'actions'   => [
        'transform' => 'Transform',
    ],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Unknown or invalid module.',
        ],
        'success'   => '{1} :count entity transformed to new module :type.|[2,*] :count entities transformed to new module :type.',
    ],
    'fields'    => [
        'current'       => 'Current module',
        'select_one'    => 'Select one',
        'target'        => 'New module',
    ],
    'panel'     => [
        'bulk_description'  => 'Change the module of multiple entities. Please be aware that some data might be lost due to the different fields between modules.',
        'bulk_title'        => 'Bulk transform entities',
        'description'       => 'Did you create this entity in one module but realised another one would suit it better? No worries, you can change the entity\'s module at any time. Please be aware that some data might be lost due to the different fields between modules.',
        'title'             => 'Transform an entity',
    ],
    'success'   => 'Entity :name transformed.',
    'title'     => 'Transform :name',
];
