<?php

return [
    'actions' => [
        'update' => 'Edit marker',
    ],
    'create' => [
        'title' => 'New Marker',
        'success' => 'Marker :name created.',
    ],
    'delete' => [
        'success' => 'Marker :name deleted,',
    ],
    'edit' => [
        'title' => 'Edit Marker :name',
        'success' => 'Marker :name updated.',
    ],
    'fields' => [
        'custom_icon' => 'Custom Icon',
        'custom_shape' => 'Custom Shape',
        'is_draggable' => 'Draggable',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'opacity' => 'Opacity',
    ],
    'helpers' => [
        'base' => 'Add markers to the map by clicking on any spot.',
        'custom_icon' => 'Copy the html of an icon from :fontawesome or :rpgawesome, or a custom SVG icon.',
        'draggable' => 'Enable to allow moving a marker in the exploration mode.',
    ],
    'icons' => [
        'exclamation' => 'Exclamation',
        'marker' => 'Marker',
        'question' => 'Question',
        'custom' => 'Custom',
        'entity' => 'Entity',
    ],
    'placeholders' => [
        'name' => 'Name of the marker',
        'custom_shape' => '100,100 200,240 340,110'
    ],
    'shapes'        => [
        0 => 'Circle',
        1 => 'Square',
        2 => 'Triangle',
        3 => 'Custom',
    ],
    'sizes'         => [
        0 => 'Tiny',
        1 => 'Standard',
        2 => 'Small',
        3 => 'Large',
        4 => 'Huge',
    ],
    'tabs' => [
        'marker' => 'Marker',
        'label' => 'Label',
        'circle' => 'Circle',
        'polygon' => 'Polygon',
    ],
];
