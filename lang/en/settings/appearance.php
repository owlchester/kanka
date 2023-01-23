<?php

return [
    'actions' => [
        'save' => 'Save settings',
    ],
    'helpers'   => [
        'campaign-order'    => 'Change the order in which campaigns are listed in the campaign switcher.',
        'date-format'       => 'Control the format in which to display real world dates.',
        'pagination'        => 'For lists that span multiple pages, define how many are visible on each page.',
        'editor' => 'Using the legacy text editor (TinyMCE) will not support mentions on mobile devices, and not have support for some features like the campaign gallery.',
        'theme'    => 'Control the look of Kanka. Campaigns can override your preference.',

        'advanced-mentions'     => 'When enabled, mentions will always render as :mention when editing texts.',
        'default-nested'        => 'When enabled, lists which supported nesting will display that way by default. This can be overridden by campaign settings.',
        'new-entity-workflow'   => 'When creating a new entity, the default workflow is to go to the list of entities. You can change this to view the newly created entity instead.',
    ],
    'success' => 'Appearance options saved.',
    'values' => [
        'pagination-sub' => ':amount (available for subscribers)',
        'pagination' => ':amount results per page',
    ],
    'fields' => [
        'advanced-mentions'             => 'Advanced mentions',
        'campaign-order'                => 'Order in which to show campaigns',
        'date-format'                   => 'Date formatting',
        'default-nested'                => 'Nested views as default',
        'editor'                        => 'Text editor',
        'new-entity-workflow'           => 'After creating a new entity',
        'pagination'                    => 'Results per page',
    ],

    'campaign-switcher'    => [
        'alphabetical'      => 'Alphabetically (A-Z)',
        'date_created'      => 'Date created (oldest first)',
        'date_joined'       => 'Date joined (oldest first)',
        'r_alphabetical'    => 'Alphabetically (Z-A)',
        'r_date_created'    => 'Date created (newest first)',
        'r_date_joined'     => 'Date Joined (newest first)',
    ],
];
