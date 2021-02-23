<?php

return [
    'actions'           => [
        'follow'    => 'Follow',
        'unfollow'  => 'Stop following',
        'join'      => 'Join',
    ],
    'campaigns'         => [
        'tabs'  => [
            'modules'   => ':count Modules',
            'roles'     => ':count Roles',
            'users'     => ':count Users',
        ],
    ],
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Edit',
            'new'       => 'New Dashboard',
            'switch'    => 'Switch to dashboard',
        ],
        'boosted'       => ':boosted_campaigns can create custom dashboards for each of the campaign roles.',
        'create'        => [
            'success'   => 'New campaign dashboard :name created.',
            'title'     => 'New Campaign Dashboard',
        ],
        'custom'        => [
            'text'  => 'You are currently editing the :name dashboard of the campaign.',
        ],
        'default'       => [
            'text'  => 'You are currently editing the default dashboard of the campaign.',
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
        'placeholders'  => [
            'name'  => 'Name of the dashboard',
        ],
        'update'        => [
            'success'   => 'Campaign dashboard :name updated.',
            'title'     => 'Update campaign dashboard :name',
        ],
        'visibility'    => [
            'default'   => 'Default',
            'none'      => 'None',
            'visible'   => 'Visible',
        ],
    ],
    'description'       => 'The home for your creativity',
    'helpers'           => [
        'follow'    => 'Following a campaign will make it appear in the campaign switcher (top-left) below your campaigns.',
        'join'      => 'This campaign is open to new members. Click to apply to join it.',
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
            'campaign'      => 'Campaign header',
            'header'        => 'Header',
            'preview'       => 'Entity preview',
            'random'        => 'Random entity',
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
        'campaign'      => [
            'helper'    => 'This widget displays the campaign header. This widget is always shown on the default dashboard.',
        ],
        'create'        => [
            'success'   => 'Widget added to the dashboard.',
        ],
        'delete'        => [
            'success'   => 'Widget removed from the dashboard.',
        ],
        'fields'        => [
            'name'  => 'Custom widget name',
            'text'  => 'Text',
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
