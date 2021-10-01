<?php

return [
    'actions'   => [
        'transform' => 'Transform',
    ],
    'fields'    => [
        'select_one'    => 'Select one',
        'target'        => 'New entity type',
    ],
    'panel'     => [
        'bulk_title' => 'Bulk transform entities',
        'bulk_description' => 'Change the entity type of multiple entities. Please be aware that some data might be lost due to the different fields between entity types.',
        'description'   => 'Did you create this entity as one type but realised another type would suit it better? No worries, you can change the entity\'s type at any time. Please be aware that some data might be lost due to the different fields between entity types.',
        'title'         => 'Transform an entity',
    ],
    'success'   => 'Entity :name transformed.',
    'title'     => 'Transform :name',
    'bulk'      => [
        'success' => '{1} :count entity transformed to new type: :type.|[2,*] :count entities transformed to new type: :type.',
        'errors' => [
            'unknown_type' => 'Unknown or invalid entity type.',
        ]
    ]
];
