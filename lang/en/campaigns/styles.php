<?php

return [
    'actions'       => [
        'current'   => 'Current theme: :theme',
        'disable'   => 'Disable',
        'enable'    => 'Enable',
        'new'       => 'New style',
    ],
    'bulks'         => [
        'delete'    => '{1} Removed :count style.|[2,*] Removed :count styles.',
        'disable'   => '{1} Disabled :count style.|[2,*] Disabled :count styles.',
        'enable'    => '{1} Enabled :count style.|[2,*] Enabled :count styles.',
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
        'here'          => 'on our blog',
        'is_enabled'    => 'Enable this theme on every page.',
        'main'          => 'You can create custom CSS styling for your premium campaign. These styles are loaded after any themes from the marketplace that are enabled for the campaign. You can learn more about styling your campaign :here.',
        'tutorial' => 'Control the visual style of the campaign. Choose colors, layout preferences, and other presentation options. These changes affect only this campaign and can be updated at any time.',
    ],
    'pitch'         => 'Create custom CSS styling to fully customise the look and feel of the campaign.',
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
