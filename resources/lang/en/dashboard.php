<?php

return [
    'campaigns'         => [
        'manage'    => 'Manage campaign',
        'tabs' => [
            'roles' => ':count Roles',
            'users' => ':count Users',
            'modules' => ':count Modules',
        ]
    ],
    'description'       => 'The home for your creativity',
    'helpers' => [
        'setup' => 'Setup your campaign\'s dashboard.'
    ],
    'latest_release'    => 'Latest Release',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Got it',
            'title'     => 'Important Notification',
        ],
    ],
    'recent'            => [
        'add'           => 'Create new :name',
        'no_entries'    => 'There are currently no entries of this type.',
        'title'         => 'Recently modified :name',
        'view'          => 'View All :name',
    ],
    'setup' => [
        'actions' => [
            'add' => 'Add a widget',
            'edit' => 'Edit a widget',
            'back_to_dashboard' => 'Back to dashboard',
        ],
        'title' => 'Campaign Dashboard Setup',
        'widgets' => [
            'preview' => 'Entity Preview',
            'calendar' => 'Calendar',
            'recent' => 'Recent',
        ]
    ],
    'settings'          => [
        'description'   => 'Customise what you see on your dashboard',
        'edit'          => [
            'success'   => 'Your changes have been saved.',
        ],
        'fields'        => [
            'helper'        => 'You can easily change what you see on your dashboard. Please be aware that this is for all your campaigns, regardless of the campaign\'s settings.',
            'recent_count'  => 'Number of recent elements',
        ],
        'title'         => 'Dashboard Settings',
    ],
    'title'             => 'Dashboard',
    'widgets' => [
        'calendar' => [
            'events_today' => 'Today',
            'previous_events' => 'Previous',
            'upcoming_events' => 'Upcoming',
            'actions' => [
                'next' => 'Change date to next day',
                'previous' => 'Change date to previous day',
            ]
        ],
        'create' => [
            'success' => 'Widget added to the dashboard.',
        ],
        'delete' => [
            'success' => 'Widget removed from the dashboard.',
        ],
        'update' => [
            'success' => 'Widget modified.',
        ],
        'recent' => [
            'title' => 'Recently modified',
        ]
    ]
];
