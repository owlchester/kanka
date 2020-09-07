<?php

return [
    'actions'       => [
        'remove'    => 'Remove marker',
        'update'    => 'Edit marker',
    ],
    'create'        => [
        'success'   => 'Marker :name created.',
        'title'     => 'New Marker',
    ],
    'delete'        => [
        'success'   => 'Marker :name deleted.',
    ],
    'edit'          => [
        'success'   => 'Marker :name updated.',
        'title'     => 'Edit Marker :name',
    ],
    'fields'        => [
        'custom_icon'   => 'Custom Icon',
        'custom_shape'  => 'Custom Shape',
        'font_colour'   => 'Icon Colour',
        'group'         => 'Marker Group',
        'is_draggable'  => 'Draggable',
        'latitude'      => 'Latitude',
        'longitude'     => 'Longitude',
        'opacity'       => 'Opacity',
    ],
    'helpers'       => [
        'base'          => 'Add markers to the map by clicking on any spot.',
        'custom_icon'   => 'Copy the HTML of an icon from :fontawesome or :rpgawesome, or a custom SVG icon.',
        'draggable'     => 'Enable to allow moving a marker in the exploration mode.',
    ],
    'icons'         => [
        'custom'        => 'Custom',
        'entity'        => 'Entity',
        'exclamation'   => 'Exclamation',
        'marker'        => 'Marker',
        'question'      => 'Question',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Required if no entity selected',
    ],
    'shapes'        => [
        '0' => 'Circle',
        '1' => 'Square',
        '2' => 'Triangle',
        '3' => 'Custom',
    ],
    'sizes'         => [
        '0' => 'Tiny',
        '1' => 'Standard',
        '2' => 'Small',
        '3' => 'Large',
        '4' => 'Huge',
    ],
    'tabs'          => [
        'circle'    => 'Circle',
        'label'     => 'Label',
        'marker'    => 'Marker',
        'polygon'   => 'Polygon',
    ],
];
