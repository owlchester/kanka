<?php

return [
    'create'        => [
        'description'           => 'Create a new campaign',
        'helper'                => [
            'first' => 'Thanks for trying our app out! Before we can go any further, we need you to provide one simple thing for us, your <b>campaign name</b>. This is the name of your world that separates it from others, so it has to be unique. If you don\'t have a good name yet, don\'t worry, you can <b>always change it later</b>, or create more campaigns.',
            'second'=> 'But enough chit-chat! So, what\'s it going to be?',
            'title' => 'Welcome to :name!',
        ],
        'success'               => 'Campaign created.',
        'success_first_time'    => 'Your campaign has been created! Since it\'s your first campaign, we\'ve created a few things to help you get started and hopefully provide a bit of inspiration on what you can do.',
        'title'                 => 'Create a new campaign',
    ],
    'destroy'       => [
        'success'   => 'Campaign removed.',
    ],
    'edit'          => [
        'description'   => 'Edit your campaign',
        'success'       => 'Campaign updated.',
        'title'         => 'Edit Campaign :campaign',
    ],
    'fields'        => [
        'description'   => 'Description',
        'image'         => 'Image',
        'locale'        => 'Locale',
        'name'          => 'Name',
    ],
    'index'         => [
        'actions'       => [
            'new'   => [
                'description'   => 'Create a new campaign',
                'title'         => 'New Campaign',
            ],
        ],
        'add'           => 'New Campaign',
        'description'   => 'Manage your campaigns.',
        'list'          => 'Your campaigns',
        'select'        => 'Select a campaign',
        'title'         => 'Campaigns',
    ],
    'invites'       => [
        'actions'       => [
            'add'   => 'Invite',
        ],
        'create'        => [
            'button'        => 'Invite',
            'description'   => 'Invite a friend to your campaign',
            'success'       => 'Invitation sent.',
            'title'         => 'Invite someone to your campaign',
        ],
        'destroy'       => [
            'success'   => 'Invitation removed.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Join :name\'s campaign</a>',
            'subject'   => ':name has invited you to join their campaign \':campaign\' on kanka.io! Use the following link to accept their invitation.',
            'title'     => 'Invitation from :name',
        ],
        'error'         => [
            'already_member'    => 'You are already a member of that campaign.',
            'inactive_token'    => 'This token has already been used, or the campaign no longer exists.',
            'invalid_token'     => 'This token is no longer valid.',
            'login'             => 'Please log in or register to join the campaign.',
        ],
        'fields'        => [
            'created'   => 'Sent',
            'email'     => 'Email',
        ],
        'placeholders'  => [
            'email' => 'Email address of the person you wish to invite',
        ],
    ],
    'leave'         => [
        'confirm'   => 'Are you sure you want to leave the :name campaign? You won\'t be able to access it anymore, unless an owner of the campaign invites you again.',
        'error'     => 'Can\'t leave the campaign.',
        'success'   => 'You have left the campaign.',
    ],
    'members'       => [
        'create'    => [
            'title' => 'Add a member to your campaign',
        ],
        'edit'      => [
            'description'   => 'Edit a member of your campaign',
            'title'         => 'Edit member :name',
        ],
        'fields'    => [
            'joined'    => 'Joined',
            'name'      => 'User',
            'role'      => 'Role',
        ],
        'invite'    => [
            'description'   => 'You can invite friends to join your campaign by providing their email address. Once they accept the invitation, they will be added as a \'Viewer\'. You can also cancel the invitation at any time.',
            'title'         => 'Invite',
        ],
        'help' => 'There is no limit on the amount of members a campaign can have, and as an Admin of the campaign, you can remove members that are no longer active from it.',
        'roles'     => [
            'member'    => 'Member',
            'owner'     => 'Owner',
            'viewer'    => 'Viewer',
        ],
        'your_role' => 'Your role: <i>:role</i>',
    ],
    'placeholders'  => [
        'description'   => 'A short summary of your campaign',
        'locale'        => 'Language code',
        'name'          => 'Your campaign name',
    ],
    'roles'         => [
        'actions'       => [
            'add'   => 'Add a role',
        ],
        'create'        => [
            'success'   => 'Role created.',
            'title'     => 'Create a new role for :name',
        ],
        'destroy'       => [
            'success'   => 'Role removed.',
        ],
        'edit'          => [
            'success'   => 'Role updated.',
            'title'     => 'Edit Role :name',
        ],
        'fields'        => [
            'name'          => 'Name',
            'permissions'   => 'Permissions',
            'users'         => 'Users',
        ],
        'helper'        => [
            1 => 'A campaign can have as many roles as wanted. The "Admin" role automatically has access to everything in a campaign, but every other role can have specific permissions on different types of entities (character, location, etc).',
            2 => 'Entities can have more fine-tuned permissions by viewing the "Permissions" tab of an entity. This tab appears once your campaign has several roles or members.',
            3 => 'One can either go with an "opt-out" system, where roles are given access to viewing all of the entities, and use the "Private" checkbox on entities to hide them. Or one can not give roles many permissions, but set each entitity to be visible individually.',
        ],
        'members'       => 'Members',
        'permissions'   => [
            'hint'  => 'This role automatically has access to everything.',
            'actions' => [
                'read' => 'View',
                'edit' => 'Edit',
                'add' => 'Create',
                'delete' => 'Delete',
                'permission' => 'Manage Permissions',
            ],
        ],
        'placeholders'  => [
            'name'  => 'Name of the role',
        ],
        'show'          => [
            'description'   => 'Members and Permissions of a campaign role',
            'title'         => 'Campaign Roles',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Add',
            ],
            'create'    => [
                'success'   => 'User added to the role.',
                'title'     => 'Add a member to the :name role',
            ],
            'destroy'   => [
                'success'   => 'User removed from the role.',
            ],
            'fields'    => [
                'name'  => 'Name',
            ],
        ],
    ],
    'settings'      => [
        'edit'      => [
            'success'   => 'Campaign settings updated.',
        ],
        'helper'    => 'You can easily disable elements from your campaign that will be hidden. If you have already created elements in the categories you disable, they won\'t be deleted, just hidden.',
    ],
    'show'          => [
        'actions'       => [
            'leave' => 'Leave campaign',
        ],
        'description'   => 'A detailed view of a campaign',
        'tabs'          => [
            'information'   => 'Information',
            'members'       => 'Members',
            'roles'         => 'Roles',
            'settings'      => 'Settings',
        ],
        'title'         => 'Campaign :name',
    ],
];
