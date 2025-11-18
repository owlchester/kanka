<?php

return [
    'actions'   => [
        'convert' => 'Convert to module',
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
        'select_one'    => 'Select target module',
        'target'        => 'New module',
    ],
    'panel'     => [
        'warning' => 'Some data may not carry over if the new module uses different fields.',
        'bulk_description'  => 'Convert the module of multiple entities. Please be aware that some data might be lost due to the different fields between modules.',
        'bulk_title'        => 'Bulk transform entities',
        'title'       => 'You can convert this entity to another module.',
    ],
    'success'   => 'Entity :name transformed.',
    'documentation' => 'Documentation: Converting entity modules',
    'title'     => 'Convert :name',
];
