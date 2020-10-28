<?php

return [
    'actions'           => [
        'follow'    => 'Follow',
        'unfollow'  => 'Stop following',
    ],
    'campaigns'         => [
        'tabs'  => [
            'modules'   => ':count Modules',
            'roles'     => ':count Roles',
            'users'     => ':count Users',
        ],
    ],
    'description'       => 'The home for your creativity',
    'helpers'           => [
        'follow'    => 'Following a campaign will make it appear in the campaign switcher (top-left) below your campaigns.',
        'setup'     => 'Setup your campaign\'s dashboard.',
    ],
    'latest_release'    => 'Latest Release',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Got it',
            'title'     => 'Important Notification',
        ],
    ],
    'recent'            => [
        'title' => 'Recently modified :name',
    ],
    'settings'          => [
        'title' => 'Dashboard Settings',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Add a widget',
            'back_to_dashboard' => 'Back to dashboard',
            'edit'              => 'Edit a widget',
        ],
        'title'     => 'Campaign Dashboard Setup',
        'widgets'   => [
            'calendar'      => 'Calendar',
            'preview'       => 'Entity preview',
            'random'        => 'Random Entity',
            'recent'        => 'Recently modified',
            'unmentioned'   => 'Unmentioned entities',
        ],
    ],
    'title'             => 'Dashboard',
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Change date to next day',
                'previous'  => 'Change date to previous day',
            ],
            'events_today'      => 'Today',
            'previous_events'   => 'Previous',
            'upcoming_events'   => 'Upcoming',
        ],
        'create'        => [
            'success'   => 'Widget added to the dashboard.',
        ],
        'delete'        => [
            'success'   => 'Widget removed from the dashboard.',
        ],
        'fields'        => [
            'width' => 'Width',
        ],
        'recent'        => [
            'entity-header' => 'Use entity header as image',
            'full'          => 'Full',
            'help'          => 'Only show the last updated entity, but show a whole preview of the entity',
            'helpers'       => [
                'entity-header' => 'If your entity has an entity header (boosted campaign feature), set this widget to use that image instead of the entity\'s image.',
                'full'          => 'Display the whole entity\'s entry by default instead of a preview.',
            ],
            'singular'      => 'Singular',
            'tags'          => 'Filter the list of recently modified entities on specified tags.',
            'title'         => 'Recently modified',
        ],
        'unmentioned'   => [
            'title' => 'Unmentioned entities',
        ],
        'update'        => [
            'success'   => 'Widget modified.',
        ],
        'widths'        => [
            '0' => 'Auto',
            '12'=> 'Full (100%)',
            '3' => 'Tiny (25%)',
            '4' => 'Small (33%)',
            '6' => 'Half (50%)',
            '8' => 'Wide (66%)',
        ],
    ],
];
