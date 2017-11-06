<?php

return [
    'index' => [
        'title' => 'Campaigns',
        'description' => 'Manage your campaigns.',
        'add' => 'New Campaign',
        'select' => 'Select a campaign',
        'list' => 'Your campaigns',
        'actions' => [
            'new' => [
                'title' => 'New Campaign',
                'description' => 'Create a new campaign',
            ]
        ]
    ],
    'create' => [
        'title' => 'Create a new campaign',
        'description' => '',
        'success' => 'Campaign created.',
        'success_first_time' => 'Your campaign has been created! Since it\'s your first campaign, we\'ve created a few things to help you get started and hopefully provide a bit of inspiration on what you can do.',

        'helper' => [
            'title' => 'Welcome to :name!',
            'first' => 'Thanks for trying our app out! Before we can go any further, we need you to provide one simple thing for us, your <b>campaign name</b>. This is the name of your world that separates it from others, so it has to be unique. If you don\'t have a good name yet, don\'t worry, you can <b>always change it later</b>, or create more campaigns.',
            'second' => 'But enough chit-chat! So, what\'s it going to be?',
        ]
    ],
    'show' => [
        'title' => 'Campaign :name',
        'description' => 'A detailed view of a campaign',
    ],
    'edit' => [
        'title' => 'Edit Campaign :campaign',
        'description' => '',
        'success' => 'Campaign updated.',
    ],
    'destroy' => [
        'success' => 'Campaign removed.',
    ],
    'fields' => [
        'name' => 'Name',
        'image' => 'Image',
        'locale' => 'Locale',
        'description' => 'Description',
    ],
    'placeholders' => [
        'name' => 'Your campaign name',
        'locale' => 'Language code',
        'description' => 'A short summary of your campaign',
    ],
    'members' => [
        'create' => [
            'title' => 'Add a member to your campaign',
        ],
        'invite' => [
            'title' => 'Invite',
            'description' => 'Use the following link to invite one person to your campaign. Once they have used the link, it will no longer be available and a new one will be generated.',
        ],
        'edit' => [
            'title' => 'Edit member :name',
        ],
        'fields' => [
            'name' => 'User',
            'role' => 'Role',
            'joined' => 'Joined',
        ],
    ]
];
