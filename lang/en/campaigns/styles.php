<?php

return [
    'actions'       => [
        'builder'   => 'Theme Builder',
        'current'   => 'Current theme: :theme',
        'disable'   => 'Disable',
        'enable'    => 'Enable',
        'new'       => 'New style',
        'new_first' => 'Create your first style',
    ],
    'bulks'         => [
        'delete'    => '{1} Removed :count style.|[2,*] Removed :count styles.',
        'disable'   => '{1} Disabled :count style.|[2,*] Disabled :count styles.',
        'enable'    => '{1} Enabled :count style.|[2,*] Enabled :count styles.',
    ],
    'cta' => [
        'title' => 'Custom CSS is a premium feature.',
        'lead' => 'Upgrade to write custom CSS and fully restyle this campaign.',
        'helper' => 'Upgrade to premium to write custom CSS and style this campaign your way.',
    ],
    'create'        => [
        'success'   => 'New style created.',
        'title'     => 'New style',
    ],
    'delete'        => [
        'success'   => 'Style :name deleted.',
    ],
    'errors'        => [
        'max_content'   => 'The CSS rule can\'t be longer than :amount characters.',
        'max_reached'   => 'Max number of styles (:max) reached.',
    ],
    'fields'        => [
        'content'       => 'CSS rule',
        'is_enabled'    => 'Enabled',
        'length'        => 'Length',
        'modified'      => 'Modified',
        'name'          => 'Name',
        'order'         => 'Order',
    ],
    'helpers'       => [
        'empty' => 'No custom styles yet',
        'what' => 'Use the Theme Builder for guided styling, or write your own CSS from scratch.',
        'here'          => 'on our blog',
        'is_enabled'    => 'Enable this theme on every page.',
        'main'          => 'Create custom CSS styling for your premium campaign. Styles are loaded in the order shown above, after any themes from the plugin library that are enabled. Learn more :here.',
        'tutorial'      => 'Control the visual style of the campaign. Choose colors, layout preferences, and other presentation options. These changes affect only this campaign and can be updated at any time.',
    ],
    'pitch'         => 'Make your campaign look and feel entirely your own with custom CSS.',
    'placeholders'  => [
        'name'  => 'Name of the style',
    ],
    'reorder'       => [
        'save'      => 'Save new order',
        'success'   => '{1} Reordered :count style.|[2,*] Reordered :count styles.',
        'title'     => 'Reorder styles',
    ],
    'theme'         => [
        'none'      => 'Use user\'s preference',
        'override'  => 'Theme override',
        'success'   => 'Theme override updated.',
        'title'     => 'Update the theme override',
    ],
    'title'         => 'Theming',
    'toggle'        => [
        'disable'   => 'Style disabled successfully.',
        'enable'    => 'Style enabled successfully.',
    ],
    'update'        => [
        'success'   => 'Style :name updated.',
        'title'     => 'Update style',
    ],
];
