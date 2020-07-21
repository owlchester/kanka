<?php

return [
    //'helper' => '',
    'actions' => [
        'add' => 'Add a new layer'
    ],
    'base' => 'Base Layer',
    'create' => [
        'title' => 'New Layer',
        'success' => 'Layer :name created.',
    ],
    'delete' => [
        'success' => 'Layer :name deleted.',
    ],
    'edit' => [
        'title' => 'Edit Layer :name',
        'success' => 'Layer :name updated.',
    ],
    'fields' => [
        'position' => 'Position',
    ],
    'helper' => [
        'amount' => 'You can add up to :amount layers on a map to switch the background image displayed below your markers.',
        'boosted_campaign' => ':boosted can have up to :amount layers.',
    ],
    'placeholders' => [
        'name' => 'Underground, Level 2, Shipwreck',
        'position' => 'Optional field to set the order in which the layers appear.',
    ]
];
