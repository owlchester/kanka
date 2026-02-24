<?php

return [
    'actions'       => [
        'customise' => 'Customise dashboard',
        'follow'    => 'Follow',
        'join'      => 'Join',
        'unfollow'  => 'Stop following',
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'  => 'Edit name & permissions',
            'new'   => 'New Dashboard',
        ],
        'create'        => [
            'helper'    => 'Create a new dashboard for :name, and assign which roles can see it or have it as their default dashboard.',
            'success'   => 'New dashboard :name created.',
            'title'     => 'New dashboard',
        ],
        'custom'        => [
            'text'  => 'You are currently editing the :name dashboard.',
        ],
        'default'       => [
            'text'  => 'You are currently editing the default dashboard of :campaign.',
            'title' => 'Default Dashboard',
        ],
        'delete'        => [
            'success'   => 'Dashboard :name removed.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copy widgets',
            'name'          => 'Dashboard name',
            'visibility'    => 'Visibility',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplicate the widgets from the :name dashboard into this new one.',
        ],
        'pitch'         => 'Create multiple dashboards with custom permissions for each role.',
        'placeholders'  => [
            'name'  => 'Name of the dashboard',
        ],
        'update'        => [
            'success'   => 'Dashboard :name updated.',
            'title'     => 'Update dashboard',
        ],
        'visibility'    => [
            'default'   => 'Default',
            'none'      => 'None',
            'visible'   => 'Visible',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Following a campaign will make it appear in the campaign switcher below your own campaigns.',
        'join'      => 'This campaign is open to new members. Click to apply to join it.',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Widget',
            'back_to_dashboard' => 'Back to dashboard',
            'edit'              => 'Edit a widget',
            'new'               => 'New :type widget',
        ],
        'reorder'   => [
            'helper'    => 'Drag me to move me around',
            'success'   => 'Widgets reordered.',
        ],
        'title'     => 'Dashboard Setup',
        'tutorial'  => [
            'blog'  => 'our tutorial',
            'text'  => 'Need help setting up the dashboard? Read :blog for some help and inspiration.',
        ],
    ],
    'title'         => 'Dashboard',
    'widgets'       => [
        'advanced_options_boosted'  => 'Enable more options like showing pins with a :boosted_campaign.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Change date to next day',
                'previous'  => 'Change date to previous day',
            ],
            'previous_events'   => 'Previous',
            'upcoming_events'   => 'Upcoming',
        ],
        'campaign'                  => [
            'helper'    => 'This widget displays a billboard. This widget is always shown on the default dashboard.',
        ],
        'create'                    => [
            'helper'            => 'Select a widget type to add to the :name dashboard.',
            'helper-default'    => 'Select a widget type to add to the default dashboard.',
            'success'           => 'Widget added to the dashboard.',
            'title'             => 'New widget',
        ],
        'delete'                    => [
            'success'   => 'Widget removed from the dashboard.',
        ],
        'fields'                    => [
            'class'             => 'CSS class',
            'dashboard'         => 'Dashboard',
            'name'              => 'Custom widget name',
            'optional-entity'   => 'Link to entry',
            'order'             => 'Ordering',
            'size'              => 'Size',
            'width'             => 'Width',
        ],
        'helpers'                   => [
            'class'     => 'Define a custom CSS class added to the widget.',
            'filters'   => 'Click to learn about the available filter options.',
        ],
        'orders'                    => [
            'name_asc'  => 'Name ascending',
            'name_desc' => 'Name descending',
            'oldest'    => 'Oldest modified',
            'recent'    => 'Recently modified',
        ],
        'preview'                   => [
            'displays'  => [
                'expand'    => 'Expandable entry',
                'full'      => 'Full entry',
            ],
            'fields'    => [
                'display'   => 'Display',
            ],
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'You can reference the random entry\'s name with {name}',
            ],
            'type'      => [
                'all'   => 'All',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Advanced filter',
            'advanced_filters'  => [
                'mentionless'   => 'Mentionless (entries that don\'t mention other entries)',
                'unmentioned'   => 'Unmentioned (entries that aren\'t mentioned by other entries)',
            ],
            'all-entities'      => 'All entries',
            'entity-header'     => 'Use entry header as image',
            'filters'           => 'Filters',
            'help'              => 'Only show the first entry as a preview instead of a list.',
            'helpers'           => [
                'entity-header'     => 'If the entry has a header image (premium campaign feature), set this widget to use that image instead of the entry\'s image.',
                'show_attributes'   => 'Show the entry\'s pinned properties below the entry.',
                'show_members'      => 'If the entry is a family or organisation, show its members below the entry.',
                'show_relations'    => 'Show the entry\'s pinned relations below the entry.',
            ],
            'show_attributes'   => 'Show pinned properties',
            'show_members'      => 'Show members',
            'show_relations'    => 'Show pinned relations',
            'singular'          => 'Preview',
            'tags'              => 'Filter the list of entries on specified tags.',
            'title'             => 'Entry list',
        ],
        'tabs'                      => [
            'advanced'  => 'Advanced',
            'setup'     => 'Setup',
        ],
        'unmentioned'               => [
            'title' => 'Unmentioned entries',
        ],
        'update'                    => [
            'success'   => 'Widget modified.',
        ],
        'widths'                    => [
            '0' => 'Auto',
            '12'=> 'Full (100%)',
            '3' => 'Tiny (25%)',
            '4' => 'Small (33%)',
            '6' => 'Half (50%)',
            '8' => 'Wide (66%)',
            '9' => 'Large (75%)',
        ],
    ],
];
