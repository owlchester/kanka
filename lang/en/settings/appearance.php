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
    ],
    'fields'            => [
        'campaign-order'        => 'Campaign list order',
        'date-format'           => 'Date formatting',
        'default-nested'        => 'Nested lists layout',
        'editor'                => 'Text editor',
        'mentions'              => 'Mentions when editing',
        'new-entity-workflow'   => 'New entity workflow',
        'pagination'            => 'Results per page',
        'theme'                 => 'Theme preference',
    ],
    'helpers'           => [
        'advanced-mentions'     => 'When editing texts, control if mentions are rendered as the entity\'s name, or as the advanced mention.',
        'campaign-order'        => 'Change the order in which campaigns are listed in the campaign switcher.',
        'date-format'           => 'When available, control the format in which to display real world dates.',
        'default-nested'        => 'Control how lists which support nesting to be displayed by default.',
        'editor'                => 'Using the legacy text editor (TinyMCE) doesn\'t support mentions on mobile devices, campaign galleries or other advanced features.',
        'new-entity-workflow'   => 'Control which interface you are taken to after creating a new entity.',
        'overridable'           => 'Individual campaigns can override this preference.',
        'pagination'            => 'For lists that span multiple pages, define how many are visible on each page.',
        'theme'                 => 'Choose how Kanka looks to you.',
    ],
    'mentions'          => [
        'advanced'  => 'Display advanced mentions :code',
        'default'   => 'Mentions as the entity name',
    ],
    'nested'            => [
        'default'   => 'Flat lists',
        'nested'    => 'Nested lists',
    ],
    'success'           => 'Appearance options saved.',
    'values'            => [
        'pagination'        => ':amount results per page',
        'pagination-sub'    => ':amount (available for subscribers)',
    ],
];
