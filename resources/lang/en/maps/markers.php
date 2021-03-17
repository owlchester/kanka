<?php

return [
    'actions'       => [
        'remove'    => 'Remove marker',
        'update'    => 'Edit marker',
        'entry'     => 'Write a custom entry field for this marker.',
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
        'circle_radius' => 'Circle radius',
        'copy_elements' => 'Copy elements',
        'custom_icon'   => 'Custom Icon',
        'custom_shape'  => 'Custom Shape',
        'font_colour'   => 'Icon Colour',
        'group'         => 'Marker Group',
        'is_draggable'  => 'Draggable',
        'latitude'      => 'Latitude',
        'longitude'     => 'Longitude',
        'opacity'       => 'Opacity',
        'pin_size'      => 'Pin Size',
        'polygon_style' => [
            'stroke'    => 'Stroke colour',
            'stroke-width' => 'Stroke width',
            'stroke-opacity' => 'Stroke opacity',
        ],
    ],
    'helpers'       => [
        'base'          => 'Add markers to the map by clicking on any spot.',
        'copy_elements' => 'Copy groups, layers, and markers.',
        'copy_elements_to_campaign' => 'Copy groups, layers, and markers of the maps. Markers linked to an entity will be converted to a standard marker.',
        'custom_icon'   => 'Copy the HTML of an icon from :fontawesome or :rpgawesome, or a custom SVG icon.',
        'custom_radius' => 'Select the custom size option from the dropdown to define a size.',
        'draggable'     => 'Enable to allow moving this marker in the exploration mode of the map.',
        'label' => 'A label is displayed as a block of text on the map. The content will be the marker\'s name of the entity\'s name.',
        'polygon' => [
            'new' => 'Move the marker around on the map to save the position.',
            'edit' => 'Click on the map to add that position to the polygon\'s coordinates.',
        ]
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
