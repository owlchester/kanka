<?php

return [
    'create'        => [
        'description'   => 'Create a new section',
        'success'       => 'Section \':name\' created.',
        'title'         => 'New Section',
    ],
    'destroy'       => [
        'success'   => 'Section \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Section \':name\' updated.',
        'title'         => 'Edit Section :name',
    ],
    'fields'        => [
        'characters'    => 'Characters',
        'image'         => 'Image',
        'section'      => 'Section',
        'sections'     => 'Sections',
        'map'           => 'Map',
        'name'          => 'Name',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Exploration View',
        ],
        'add'           => 'New Section',
        'description'   => 'Manage the section of :name.',
        'header'        => 'Sections in :name',
        'title'         => 'Sections',
    ],
    'placeholders'  => [
        'section'  => 'Choose a parent section',
        'name'      => 'Name of the section',
        'type'      => 'City, Kingdom, Ruin',
    ],
    'show'          => [
        'description'   => 'A detailed view of a section',
        'tabs'          => [
            'children'    => 'Children',
            'information'   => 'Information',
            'sections'     => 'Sections',
        ],
        'title'         => 'Section :name',
    ],
];
