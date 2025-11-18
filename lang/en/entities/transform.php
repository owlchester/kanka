<?php

return [
    'actions'   => [
        'transform' => 'Convert',
    ],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Unknown or invalid module.',
        ],
        'success'   => '{1} :count entity transformed to new module :type.|[2,*] :count entities transformed to new module :type.',
    ],
    'confirm'   => [
        'checkbox'  => 'I understand that by transforming :entity to another module, the following elements will be lost:',
        'label'     => 'Confirm data loss',
    ],
    'fields'    => [
        'current'       => 'Current module',
        'select_one'    => 'Select one',
        'target'        => 'New module',
    ],
    'panel'     => [
        'bulk_description'  => 'Change the module of multiple entities. Please be aware that some data might be lost due to the different fields between modules.',
        'bulk_title'        => 'Bulk transform entities',
        'description'       => 'You can convert this entity to another module. Some data may not carry over if the modules use different fields.',
        'title'             => 'Transform an entity',
    ],
    'success'   => 'Entity :name transformed.',
    'documentation' => 'Documentation: Converting entity modules',
    'title'     => 'Convert :name',
];
