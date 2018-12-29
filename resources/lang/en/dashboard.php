<?php

return [
    'campaigns'         => [
        'manage'    => 'Manage campaign',
        'tabs'      => [
            'modules'   => ':count Modules',
            'roles'     => ':count Roles',
            'users'     => ':count Users',
        ],
    ],
    'description'       => 'The home for your creativity',
    'helpers'           => [
        'setup' => 'Setup your campaign\'s dashboard.',
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
    'setup'             => [
        'actions'   => [
            'add'               => 'Add a widget',
            'back_to_dashboard' => 'Back to dashboard',
            'edit'              => 'Edit a widget',
        ],
        'title'     => 'Campaign Dashboard Setup',
        'widgets'   => [
            'calendar'  => 'Calendar',
            'preview'   => 'Entity Preview',
            'recent'    => 'Recent',
        ],
    ],
    'title'             => 'Dashboard',
    'widgets'           => [
        'calendar'  => [
            'actions'           => [
                'next'      => 'Change date to next day',
                'previous'  => 'Change date to previous day',
            ],
            'events_today'      => 'Today',
            'previous_events'   => 'Previous',
            'upcoming_events'   => 'Upcoming',
        ],
        'create'    => [
            'success'   => 'Widget added to the dashboard.',
        ],
        'delete'    => [
            'success'   => 'Widget removed from the dashboard.',
        ],
        'recent'    => [
            'title' => 'Recently modified',
        ],
        'update'    => [
            'success'   => 'Widget modified.',
        ],
    ],
];
