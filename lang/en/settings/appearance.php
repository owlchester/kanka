<?php

return [
    'dismissible' => [
        'main' => 'Control the way Kanka looks and feels. Please note that campaigns can override some of these settings.',
    ],
    'actions' => [
        'save' => 'Save settings',
        'learn-more' => 'Learn more about this setting in our documentation.',
    ],
    'helpers'   => [
        'campaign-order'    => 'Change the order in which campaigns are listed in the campaign switcher.',
        'date-format'       => 'Control the format in which to display real world dates.',
        'pagination'        => 'For lists that span multiple pages, define how many are visible on each page.',
        'editor' => 'Using the legacy text editor (TinyMCE) doesn\'t support mentions on mobile devices, campaign galleries or other advanced features.',
        'theme'    => 'Choose how Kanka looks to you.',

        'advanced-mentions'     => 'When editing texts, control if mentions are rendered as the entity\'s name, or as the advanced mention.',
        'default-nested'        => 'Control how lists which support nesting to be displayed by default. ',
        'new-entity-workflow'   => 'Control which interface you are taken to after creating a new entity.',
        'overridable' => 'Individual campaigns can override this preference.'
    ],
    'success' => 'Appearance options saved.',
    'values' => [
        'pagination-sub' => ':amount (available for subscribers)',
        'pagination' => ':amount results per page',
    ],
    'fields' => [
        'mentions'                      => 'Mentions when editing',
        'campaign-order'                => 'Campaign list order',
        'date-format'                   => 'Date formatting',
        'default-nested'                => 'Nested lists layout',
        'editor'                        => 'Text editor',
        'new-entity-workflow'           => 'New entity workflow',
        'pagination'                    => 'Results per page',
        'theme'                         => 'Theme preference'
    ],

    'campaign-switcher'    => [
        'alphabetical'      => 'Alphabetically (A-Z)',
        'date_created'      => 'Date created (oldest first)',
        'date_joined'       => 'Date joined (oldest first)',
        'r_alphabetical'    => 'Alphabetically (Z-A)',
        'r_date_created'    => 'Date created (newest first)',
        'r_date_joined'     => 'Date Joined (newest first)',
    ],

    'editors'                       => [
        'legacy'        => 'Legacy (:name)',
        'default'    => 'Default (:name)',
    ],
    'nested' => [
        'default' => 'Flat lists',
        'nested' => 'Nested lists',
    ],
    'mentions' => [
        'default' => 'Mentions as the entity name',
        'advanced' => 'Display advanced mentions :code',
    ],
];
