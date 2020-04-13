<?php

return [
    'avatar'        => [
        'success'   => 'Avatar updated.',
    ],
    'description'   => 'Update your profile details',
    'edit'          => [
        'success'   => 'Profile updated',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'last_login_share'          => 'Share with other campaign members when I last logged in.',
        'name'                      => 'Name',
        'new_password'              => 'New Password',
        'new_password_confirmation' => 'New Password Confirmation',
        'newsletter'                => 'I wish to sometimes be contacted by email.',
        'password'                  => 'Current password',
        'settings'                  => 'Settings',
        'theme'                     => 'Theme',
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
            'title'     => 'Delete your account',
            'warning'   => 'By deleting your account, all your data will be lost. Are you sure?',
        ],
        'password'  => [
            'title' => 'Change your password',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions' => 'Advanced Mentions',
            'date_format'       => 'Date Formatting',
            'default_nested'    => 'Nested Views as Default',
            'pagination'        => 'Pagination (elements per page)',
        ],
        'hints'     => [
            'advanced_mentions' => 'If activated, mentions will always render as [entity:123] when editing an entity.',
            'default_nested'    => 'Activate this option if you wish for the default lists to be Nested by default (when available).',
        ],
        'success'   => 'Settings changed.',
    ],
    'newsletter' => [
        'title' => 'Newsletters',
        'settings' => [
            'newsletter' => 'Newsletter - receive the Kanka newsletter.',
            'votes' => 'Community Votes - be notified as soon as a new :vote is available.',
            'news' => 'News - be notified when there\'s :news.',
        ],
        'links' => [
            'community-vote' => 'Community Vote',
            'news' => 'News',
        ],
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
];
