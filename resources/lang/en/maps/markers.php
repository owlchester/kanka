<?php

return [
    'actions'       => [
        'entry'             => 'Write a custom entry field for this marker.',
        'remove'            => 'Remove marker',
        'save_and_explore'  => 'Save and Explore',
        'update'            => 'Edit marker',
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
            'stroke'            => 'Stroke colour',
            'stroke-opacity'    => 'Stroke opacity',
            'stroke-width'      => 'Stroke width',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Add markers to the map by clicking on any spot.',
        'copy_elements'             => 'Copy groups, layers, and markers.',
        'copy_elements_to_campaign' => 'Copy groups, layers, and markers of the maps. Markers linked to an entity will be converted to a standard marker.',
        'custom_icon'               => 'Copy the HTML of an icon from :fontawesome or :rpgawesome, or a custom SVG icon.',
        'custom_radius'             => 'Select the custom size option from the dropdown to define a size.',
        'draggable'                 => 'Enable to allow moving this marker in the exploration mode of the map.',
        'label'                     => 'A label is displayed as a block of text on the map. The content will be the marker\'s name or the entity\'s name.',
        'polygon'                   => [
            'edit'  => 'Click on the map to add that position to the polygon\'s coordinates.',
            'new'   => 'Move the marker around on the map to save the position to the polygone.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Custom icon',
        'entity'        => 'Entity\'s picture',
        'exclamation'   => 'Exclamation icon',
        'marker'        => 'Marker icon',
        'question'      => 'Question icon',
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
