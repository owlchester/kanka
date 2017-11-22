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
        'actions' => [
            'leave' => 'Leave campaign',
        ],
        'tabs' => [
            'information' => 'Information',
            'members' => 'Members',
            'settings' => 'Settings',
        ],
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
            'description' => 'You can invite friends to join your campaign by providing their email address. Once ' .
            'they accept the invitation, they will be added as a \'Viewer\'. You can also cancel the invitation at ' .
            'any time.',
        ],
        'edit' => [
            'title' => 'Edit member :name',
            'description' => '',
        ],
        'fields' => [
            'name' => 'User',
            'role' => 'Role',
            'joined' => 'Joined',
        ],
        'your_role' => 'You are a <i>:role</i>',
        'roles' => [
            'owner' => 'Owner',
            'member' => 'Member',
            'viewer' => 'Viewer',
        ]
    ],
    'invites' => [
        'fields' => [
            'email' => 'Email',
            'created' => 'Sent',
        ],
        'placeholders' => [
            'email' => 'Email address of the person you wish to invite',
        ],
        'actions' => [
            'add' => 'Invite',
        ],
        'create' => [
            'success' => 'Invitation sent.',
            'title' => 'Invite someone to your campaign',
            'description' => '',
            'button' => 'Invite',
        ],
        'destroy' => [
            'success' => 'Invitation removed.',
        ],
        'email' => [
            'title' => 'Invitation from :name',
            'subject' => ':name has invited you to join his campaign \':campaign\' on kanka.io! ' .
                'Use the following link to accept his invitation.',
            'link' => '<a href=":link">Join :name\'s campaign</a>'
        ],
        'error' => [
            'invalid_token' => 'This token is no longer valid.',
            'inactive_token' => 'This token has already been used, or the campaign no longer exists.',
            'login' => 'Please log in or register to join the campaign.',
            'already_member' => 'You are already a member of that campaign.'
        ]
    ],
    'settings' => [
        'fields' => [
            'characters' => 'Characters',
            'events' => 'Events',
            'families' => 'Families',
            'items' => 'Items',
            'journals' => 'Journals',
            'locations' => 'Locations',
            'notes' => 'Notes',
            'organisations' => 'Organisations',
            'quests' => 'Quests',
        ],
        'edit' => [
            'success' => 'Campaign settings updated.',
        ],
    ],
    'leave' => [
        'confirm' => 'Are you sure you want to leave the :name campaign? You won\'t be able to access it anymore, ' .
            'unless an owner of the campaign invites you again.',
        'success' => 'You have left the campaign.',
        'error' => 'Can\'t leave the campaign.'
    ]
];
