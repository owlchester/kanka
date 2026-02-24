<?php

return [
    'actions'       => [
        'convert'   => 'Convert to category',
    ],
    'bulk'          => [
        'errors'    => [
            'unknown_type'  => 'Unknown or invalid category.',
        ],
        'success'   => '{1} :count entry transformed to new category :type.|[2,*] :count entries transformed to new category :type.',
    ],
    'confirm'       => [
        'checkbox'  => 'I understand that by transforming :entity to another category, the following elements will be lost:',
        'label'     => 'Confirm data loss',
    ],
    'documentation' => 'Documentation: Converting entry categories',
    'fields'        => [
        'current'       => 'Current category',
        'select_one'    => 'Select new category',
        'target'        => 'New category',
    ],
    'panel'         => [
        'bulk_description'  => 'Convert the category of multiple entries. Please be aware that some data might be lost due to the different fields between categories.',
        'bulk_title'        => 'Bulk transform entries',
        'title'             => 'You can convert this entry to another category.',
        'warning'           => 'Some data may not carry over if the new category uses different fields.',
    ],
    'success'       => 'Entry :name transformed.',
    'title'         => 'Convert :name',
];
