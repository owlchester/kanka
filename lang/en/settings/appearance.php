<?php

return [
    'actions'           => [
        'learn-more'    => 'Learn more about this setting in our documentation.',
        'save'          => 'Save settings',
    ],
    'campaign-switcher' => [
        'alphabetical'      => 'Alphabetically (A-Z)',
        'date_created'      => 'Date created (oldest first)',
        'date_joined'       => 'Date joined (oldest first)',
        'r_alphabetical'    => 'Alphabetically (Z-A)',
        'r_date_created'    => 'Date created (newest first)',
        'r_date_joined'     => 'Date Joined (newest first)',
    ],
    'dismissible'       => [
        'main'  => 'Control the way Kanka looks and feels. Please note that campaigns can override some of these settings.',
    ],
    'editors'           => [
        'default'   => 'Default (:name)',
        'legacy'    => 'Legacy (:name)',
        'tiptap'    => 'Experimental 2026',
        'helpers' => [
            'legacy' => 'The legacy text editor (TinyMCE) doesn\'t support mentions on mobile devices, campaign galleries or other advanced features.',
            'tiptap' => 'This is our new experimental text editor that is actively being worked on and updated regularly. It doesn\'t yet contain all the features you might be accustomed to.',
            'feedback' => 'Help us improve it by giving feedback (2min)'
        ],
    ],
    'explore'           => [
        'grid'  => 'Grid (default)',
        'table' => 'Table',
    ],
    'fields'            => [
        'campaign-order'        => 'Campaign list order',
        'date-format'           => 'Date formatting',
        'editor'                => 'Text editor',
        'entity-explore'        => 'Entity lists',
        'mentions'              => 'Mentions',
        'new-entity-workflow'   => 'New entry workflow',
        'pagination'            => 'Results per page',
        'theme'                 => 'Theme preference',
    ],
    'helpers'           => [
        'advanced-mentions'     => 'When writing texts, control how @mentions are displayed.',
        'campaign-order'        => 'Change the order in which campaigns are listed in the campaign switcher.',
        'date-format'           => 'When available, control the format in which to display real world dates.',
        'editors'               => 'Switch between text editors for when creating or editing large text fields.',
        'entity-explore'        => 'Control the way in which entry lists are displayed on campaigns.',
        'new-entity-workflow'   => 'Control which interface you are taken to after creating a new entity.',
        'overridable'           => 'Individual campaigns can override this preference.',
        'pagination'            => 'For lists that span multiple pages, define how many are visible on each page.',
        'theme'                 => 'Choose how Kanka looks to you.',
    ],
    'mentions'          => [
        'advanced'  => 'Advanced mentions :code',
        'default'   => 'Standard mentions :mention',
    ],
    'success'           => 'Appearance options saved.',
    'values'            => [
        'pagination'        => ':amount results per page',
        'pagination-sub'    => ':amount (available for subscribers)',
    ],

];
