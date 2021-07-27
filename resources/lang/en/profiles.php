<?php

return [
    'avatar'        => [
        'success'   => 'Avatar updated.',
    ],
    'campaign_switcher_order_by' => [
        'alphabetical' => 'Alphabetically',
        'r_alphabetical' => 'Alphabetically Reversed',
        'date_joined' => 'Date Joined',
        'r_date_joined' => 'Date Joined Reversed',
        'date_created' => 'Date Created',
        'r_date_created' => 'Date Created Reversed',
    ],
    'description'   => 'Update your profile details',
    'edit'          => [
        'success'   => 'Profile updated',
    ],
    'editors'       => [
        'legacy'        => 'Legacy (TinyMCE 4)',
        'summernote'    => 'Summernote',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'hide_subscription'         => 'Hide my name from the :hall_of_fame.',
        'last_login_share'          => 'Share with other campaign members when I last logged in.',
        'name'                      => 'Name',
        'new_password'              => 'New Password',
        'new_password_confirmation' => 'New Password Confirmation',
        'newsletter'                => 'I wish to sometimes be contacted by email.',
        'password'                  => 'Current password',
        'settings'                  => 'Settings',
        'theme'                     => 'Theme',
    ],
    'newsletter'    => [
        'helpers'    => [
            'header' => 'Subscribe to the following email newsletters to be notified of what\'s going on with Kanka.',
            'monthly' => 'Our monthly recap of what\'s going on and events related to Kanka.',
            'release' => 'Get notified each time Kanka gets an update with an overview of what\'s changed.',
            'community-vote' => 'Get notified each time there is a new :community-vote going on.',
        ],
        'links'     => [
            'community-vote'    => 'Community Vote',
            'news'              => 'News',
            'updates'           => 'Kanka updates',
        ],
        'settings'  => [
            'news'          => 'News - be notified when there\'s :news.',
        ],
        'options' => [
            'monthly' => 'Kanka newsletter',
            'release' => 'New release',
        ],
        'title'     => 'Newsletters',
    ],
    'password'      => [
        'success'   => 'Password updated',
    ],
    'placeholders'  => [
        'email'                     => 'Your email address',
        'name'                      => 'Your name as displayed',
        'new_password'              => 'Your new password',
        'new_password_confirmation' => 'Confirm your new password',
        'password'                  => 'Provide your current password for any changes',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Delete my account',
            'helper'    => 'Deleting your account will also delete any campaign you are the only member of. This action is permanent and can\'t be undone.',
            'title'     => 'Delete your account',
            'warning'   => 'By deleting your account, all your data will be lost. Are you sure?',
        ],
        'password'  => [
            'title' => 'Change your password',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Advanced Mentions',
            'campaign_switcher_order_by' => 'Campaign Switcher Sorting Order',
            'date_format'           => 'Date Formatting',
            'default_nested'        => 'Nested Views as Default',
            'editor'                => 'Text Editor',
            'new_entity_workflow'   => 'New Entity Workflow',
            'pagination'            => 'Pagination (elements per page)',
        ],
        'helpers'   => [
            'editor_v2' => 'Using the legacy text editor (TinyMCE) will not support mentions on mobile devices, and not have support for some features like the campaign gallery.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'If activated, mentions will always render as [entity:123] when editing an entity.',
            'default_nested'        => 'Activate this option if you wish for the default lists to be Nested by default (when available).',
            'new_entity_workflow'   => 'When creating a new entity, the default workflow is to go to the list of entities. You can change this to view the newly created entity instead.',
        ],
        'success'   => 'Settings changed.',
    ],
    'theme'         => [
        'success'   => 'Theme changed.',
        'themes'    => [
            'dark'      => 'Dark',
            'default'   => 'Default',
            'future'    => 'Future',
            'midnight'  => 'Midnight Blue',
        ],
    ],
    'title'         => 'Update your profile',
    'workflows'     => [
        'created'   => 'Go to created entity',
        'default'   => 'List of entities',
    ],
];
