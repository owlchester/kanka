<?php

return [
    'actions'       => [
        'entry'             => 'Write a custom entry field for this marker.',
        'remove'            => 'Remove marker',
        'reset-polygon'     => 'Reset positions',
        'save_and_explore'  => 'Save and Explore',
        'start-drawing'     => 'Start drawing',
        'update'            => 'Edit marker',
    ],
    'bulks'         => [
        'delete'    => '{1} Removed :count marker.|[2,*] Removed :count markers.',
        'patch'     => '{1} Updated :count marker.|[2,*] Updated :count markers.',
    ],
    'circle_sizes'  => [
        'custom'    => 'Custom',
        'huge'      => 'Huge',
        'large'     => 'Large',
        'small'     => 'Small',
        'standard'  => 'Standard',
        'tiny'      => 'Tiny',
    ],
    'create'        => [
        'success'   => 'Marker :name created.',
        'title'     => 'New Marker',
    ],
    'delete'        => [
        'success'   => 'Marker :name deleted.',
    ],
    'details'       => [
        'from-entity'   => 'From entity',
    ],
    'edit'          => [
        'success'   => 'Marker :name updated.',
        'title'     => 'Edit Marker :name',
    ],
    'fields'        => [
        'bg_colour'     => 'Background colour',
        'circle_radius' => 'Circle radius',
        'copy_elements' => 'Copy elements',
        'custom_icon'   => 'Custom icon',
        'custom_shape'  => 'Polygon shape',
        'font_colour'   => 'Icon colour',
        'group'         => 'Marker group',
        'icon'          => 'Icon',
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
        'popupless'     => 'Tooltip popup',
        'size'          => 'Size',
    ],
    'helpers'       => [
        'base'                      => 'Add markers to the map by clicking on any spot.',
        'copy_elements'             => 'Copy groups, layers, and markers.',
        'copy_elements_to_campaign' => 'Copy groups, layers, and markers of the maps. Markers linked to an entity will be converted to a standard marker.',
        'custom_icon_v2'            => 'Use icons from :fontawesome, :rpgawesome, or a custom SVG icon. Find out how in the :docs.',
        'custom_radius'             => 'Select the custom size option from the dropdown to define a size.',
        'draggable'                 => 'This marker can be moved on the map\'s exploration page.',
        'is_popupless'              => 'Disable the marker\'s tooltip showing up on mouse hover.',
        'label'                     => 'A label is displayed as a block of text on the map. The content will be the marker\'s name or the entity\'s name.',
        'polygon'                   => [
            'edit'  => 'Edit the polygon by dragging its edges and nodes.',
        ],
    ],
    'hints'         => [
        'entry' => 'Edit the marker to write a custom entry for it.',
    ],
    'icons'         => [
        'custom'        => 'Custom icon',
        'entity'        => 'Entity\'s picture',
        'exclamation'   => 'Exclamation icon',
        'marker'        => 'Marker icon',
        'question'      => 'Question icon',
    ],
    'index'         => [
        'title' => 'Markers of :name',
    ],
    'pitches'       => [
        'poly'  => 'Use polygons to outline borders, territories, or uneven regions on the map. Available as part of premium campaign features.',
    ],
    'placeholders'  => [
        'custom_icon'   => 'Try :example1 or :example2',
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Required if no entity selected',
    ],
    'presets'       => [
        'helper'    => 'Click on a preset to load it, or create a new one.',
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
        'preset'    => 'Preset',
    ],
];
