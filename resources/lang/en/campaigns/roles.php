<?php

return [
    'actions' => [
        'status' => 'Status: :status',
    ],
    'show' => [
        'title' => ':role permissions - :campaign',
    ],
    'public' => [
        'description' => 'Set the permissions for the public role to view the following entities of the campaign. A user is automatically in the public role if they are viewing the campaign but aren\'t a member.',
        'campaign' => [
            'private' => 'The campaign is currently private.',
            'public' => 'The campaign is currently public.',
        ],
        'test' => 'To test the public role\'s permissions, open the campaign :url in an incognito window.'
    ],
    'toggle' => [
        'enabled' => 'Members of the :role role can now :action :entities',
        'disabled' => 'Members of the :role role can no longer :action :entities',
    ]
];
