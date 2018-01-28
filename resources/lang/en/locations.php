<?php

return [
    'attributes'    => [
        'actions'       => [
            'add'   => 'Add an attribute',
        ],
        'create'        => [
            'description'   => 'Set an attribute to a location',
            'success'       => 'Attribute added to :name.',
            'title'         => 'New attribute for :name',
        ],
        'destroy'       => [
            'success'   => 'Location attribute for :name removed.',
        ],
        'edit'          => [
            'description'   => '',
            'success'       => 'Location attribute for :name updated.',
            'title'         => 'Update attribute for :name',
        ],
        'fields'        => [
            'attribute' => 'Attribute',
            'value'     => 'Value',
        ],
        'placeholders'  => [
            'attribute' => 'Population, Number of floods, Garrison size',
            'value'     => 'Value of the attribute',
        ],
    ],
    'create'        => [
        'description'   => '',
        'success'       => 'Location \':name\' created.',
        'title'         => 'Create a new location',
    ],
    'destroy'       => [
        'success'   => 'Location \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Location \':name\' updated.',
        'title'         => 'Edit Location :name',
    ],
    'fields'        => [
        'characters'    => 'Characters',
        'description'   => 'Description',
        'history'       => 'History',
        'image'         => 'Image',
        'location'      => 'Location',
        'name'          => 'Name',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'index'         => [
        'add'           => 'New Location',
        'description'   => 'Manage the location of :name.',
        'header'        => 'Locations in :name',
        'title'         => 'Locations',
    ],
    'placeholders'  => [
        'location'  => 'Choose a parent location',
        'name'      => 'Name of the location',
        'type'      => 'City, Kingdom, Ruin',
    ],
    'show'          => [
        'description'   => 'A detailed view of a location',
        'tabs'          => [
            'attributes'    => 'Attributes',
            'characters'    => 'Characters',
            'information'   => 'Information',
            'locations'     => 'Locations',
            'relations'     => 'Relations',
        ],
        'title'         => 'Location :name',
    ],
];
