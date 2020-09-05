<?php

return [
    'create'                            => [
        'description'           => 'Create a new campaign',
        'helper'                => [
            'title'     => 'Welcome to :name',
            'welcome'   => <<<'TEXT'
Before going any further, you need to pick a campaign name. This is the name of your world. If you don't have a good name yet, don't worry, you can always change it later, or create more campaigns.

Thanks for joining Kanka, and welcome to our thriving community!
TEXT
,
        ],
        'success'               => 'Campaign created.',
        'success_first_time'    => 'Your campaign has been created! Since it\'s your first campaign, we\'ve created a few things to help you get started and hopefully provide a bit of inspiration on what you can do.',
        'title'                 => 'New Campaign',
    ],
    'destroy'                           => [
        'success'   => 'Campaign removed.',
    ],
    'edit'                              => [
        'description'   => 'Edit your campaign',
        'success'       => 'Campaign updated.',
        'title'         => 'Edit Campaign :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'New characters have their personality private by default.',
    ],
    'entity_visibilities'               => [
        'private'   => 'New entities are private',
    ],
    'errors'                            => [
        'access'        => 'You don\'t have access to this campaign.',
        'unknown_id'    => 'Unknown Campaign.',
    ],
    'export'                            => [
        'description'   => 'Export the campaign.',
        'errors'        => [
            'limit' => 'You have exceeded your maximum of one exports per day. Please try again tomorrow.',
        ],
        'helper'        => 'Export your campaign. A notification with a download link will be made available.',
        'success'       => 'Your campaign export is being prepared. You\'ll receive a notification in Kanka to a downloadable zip as soon as it\'s ready.',
        'title'         => 'Campaign :name Export',
    ],
    'fields'                            => [
        'boosted'                       => 'Boosted by',
        'css'                           => 'CSS',
        'description'                   => 'Description',
        'entity_count'                  => 'Entity Count',
        'entity_personality_visibility' => 'Character Personality Visibility',
        'entity_visibility'             => 'Entity Visibility',
        'excerpt'                       => 'Excerpt',
        'followers'                     => 'Followers',
        'header_image'                  => 'Header Image',
        'hide_history'                  => 'Hide entity history',
        'hide_members'                  => 'Hide campaign members',
        'image'                         => 'Image',
        'locale'                        => 'Locale',
        'name'                          => 'Name',
        'public_campaign_filters'       => 'Public Campaign Filters',
        'rpg_system'                    => 'RPG Systems',
        'system'                        => 'System',
        'theme'                         => 'Theme',
        'tooltip_family'                => 'Disable family names from tooltips',
        'tooltip_image'                 => 'Show entity image in tooltips',
        'visibility'                    => 'Visibility',
    ],
    'following'                         => 'Following',
    'helpers'                           => [
        'boost_required'                => 'This feature requires the campaign to be boosted. More info on the :settings page.',
        'boosted'                       => 'Some features are unlocked because this campaign is being boosted. Find out more on the :settings page.',
        'css'                           => 'Write your own CSS that will be loaded into the pages of your campaign. Please note that any abuse of this feature can lead to a removal of your custom CSS. Repeated or grave offenses can lead to a removal of your campaign.',
        'entity_personality_visibility' => 'When creating a new character, the "Personality Visible" option will automatically be unselected.',
        'entity_visibility'             => 'When creating a new entity, the "Private" option will automatically be selected.',
        'excerpt'                       => 'The campaign excerpt will be displayed on the dashboard, so write a few sentences introducing your world. Keep it short for the best results.',
        'hide_history'                  => 'Enable this option to hide the history of entities to non-admin members of the campaign.',
        'hide_members'                  => 'Enable this option to hide the campaign member list of the campaign to non-admin members.',
        'locale'                        => 'The language your campaign is written in. This is used for generating content and grouping public campaigns.',
        'name'                          => 'Your campaign/world can have any name as long as it contains at least 4 letters or numbers.',
        'public_campaign_filters'       => 'Help others find the campaign among other public campaigns by providing the following information.',
        'system'                        => 'If your campaign is publicly visible, the system is shown in the :link page.',
        'systems'                       => 'To avoid cluttering users with options, some features of Kanka are only available with specific RPG systems (ie the D&D 5e monster stat block). Adding supported systems here will enable those features.',
        'theme'                         => 'Force the theme for the campaign, overriding a user\'s preference.',
        'view_public'                   => 'To view your campaign as a public viewer would, open :link in an incognito window.',
        'visibility'                    => 'Making a campaign public will mean anyone with a link to it will be able to see it.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'New Campaign',
            ],
        ],
        'title'     => 'Campaign',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Invite',
            'copy'  => 'Copy the link to your clipboard',
            'link'  => 'New Link',
        ],
        'create'                => [
            'button'        => 'Invite',
            'description'   => 'Invite a friend to your campaign',
            'link'          => 'Link created: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Invitation sent.',
            'title'         => 'Invite someone to your campaign',
        ],
        'destroy'               => [
            'success'   => 'Invitation removed.',
        ],
        'email'                 => [
            'link'      => '<a href=":link">Join :name\'s campaign</a>',
            'subject'   => ':name has invited you to join their campaign \':campaign\' on kanka.io! Use the following link to accept their invitation.',
            'title'     => 'Invitation from :name',
        ],
        'error'                 => [
            'already_member'    => 'You are already a member of that campaign.',
            'inactive_token'    => 'This token has already been used, or the campaign no longer exists.',
            'invalid_token'     => 'This token is no longer valid.',
            'login'             => 'Please log in or register to join the campaign.',
        ],
        'fields'                => [
            'created'   => 'Sent',
            'email'     => 'Email',
            'role'      => 'Role',
            'type'      => 'Type',
            'validity'  => 'Validity',
        ],
        'helpers'               => [
            'email'     => 'Our emails are often flagged as spam and can take up to a few hours before appearing in your inbox.',
            'validity'  => 'How many users can use this link before it is deactivated. Leave blank for unlimited',
        ],
        'placeholders'          => [
            'email' => 'Email address of the person you wish to invite',
        ],
        'types'                 => [
            'email' => 'Email',
            'link'  => 'Link',
        ],
        'unlimited_validity'    => 'Unlimited',
    ],
    'leave'                             => [
        'confirm'   => 'Are you sure you want to leave the :name campaign? You won\'t be able to access it anymore, unless an Admin of the campaign invites you again.',
        'error'     => 'Can\'t leave the campaign.',
        'success'   => 'You have left the campaign.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Switch',
            'switch-back'   => 'Back to my user',
        ],
        'create'                => [
            'title' => 'Add a member to your campaign',
        ],
        'description'           => 'Manage the members of the campaign',
        'edit'                  => [
            'description'   => 'Edit a member of your campaign',
            'title'         => 'Edit member :name',
        ],
        'fields'                => [
            'joined'        => 'Joined',
            'last_login'    => 'Last Login',
            'name'          => 'User',
            'role'          => 'Role',
            'roles'         => 'Roles',
        ],
        'help'                  => 'Campaigns can have an unlimited amount of members in them.',
        'helpers'               => [
            'admin' => 'As a member of the campaign\'s admin role, you can invite new users, remove inactive one, and change their permissions. To test the permissions of a member, use the Switch button. You can read more about this feature in the :link.',
            'switch'=> 'Switch to this user',
        ],
        'impersonating'         => [
            'message'   => 'You are viewing the campaign as another user. Some features have been disabled, but the rest acts exactly as the user would see it. To switch back to your user, use the Switch Back button located where the Logout button is usually situated.',
            'title'     => 'Impersonating :name',
        ],
        'invite'                => [
            'description'   => 'You can invite friends to join your campaign by providing them with an Invite Link. Upon accepting their invitation, they will be added as a member in the requested role. You can also send them a request by email as long as it\'s not a Hotmail address, as they always reject Kanka\'s emails.',
            'more'          => 'You can add more roles on the :link.',
            'roles_page'    => 'Roles page',
            'title'         => 'Invite',
        ],
        'roles'                 => [
            'member'    => 'Member',
            'owner'     => 'Admin',
            'player'    => 'Player',
            'public'    => 'Public',
            'viewer'    => 'Viewer',
        ],
        'switch_back_success'   => 'You are now back to your original user.',
        'title'                 => 'Campaign :name Members',
        'your_role'             => 'Your role: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Boosted',
        'dashboard' => 'Dashboard',
        'permission'=> 'Permission',
        'sharing'   => 'Sharing',
        'systems'   => 'Systems',
        'ui'        => 'Interface',
    ],
    'placeholders'                      => [
        'description'   => 'A short summary of your campaign',
        'locale'        => 'Language code',
        'name'          => 'Your campaign name',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Add a role',
        ],
        'create'        => [
            'success'   => 'Role created.',
            'title'     => 'Create a new role for :name',
        ],
        'description'   => 'Manage the roles of the campaign',
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
            'type'          => 'Type',
            'users'         => 'Users',
        ],
        'helper'        => [
            '1' => 'A campaign can have as many roles as wanted. The "Admin" role automatically has access to everything in a campaign, but every other role can have specific permissions on different types of entities (character, location, etc).',
            '2' => 'Entities can have more fine-tuned permissions by viewing the "Permissions" tab of an entity. This tab appears once your campaign has several roles or members.',
            '3' => 'One can either go with an "opt-out" system, where roles are given access to viewing all of the entities, and use the "Private" checkbox on entities to hide them. Or one can not give roles many permissions, but set each entity to be visible individually.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'The public role has permissions but the campaign is private. You can change this setting on the Sharing tab when editing the campaign.',
            'public'                => 'The Public role is used when someone browses your public campaign. :more',
            'role_permissions'      => 'Enable the \':name\' role to do the following actions on all entities.',
        ],
        'members'       => 'Members',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Create',
                'delete'        => 'Delete',
                'edit'          => 'Edit',
                'entity-note'   => 'Entity Note',
                'permission'    => 'Permissions',
                'read'          => 'View',
                'toggle'        => 'Change for all',
            ],
            'helpers'   => [
                'entity_note'   => 'This allows users who do not have Edit permissions for an Entity to add Entity Notes to it.',
            ],
            'hint'      => 'This role automatically has access to everything.',
        ],
        'placeholders'  => [
            'name'  => 'Name of the role',
        ],
        'show'          => [
            'description'   => 'Members and Permissions of a campaign role',
            'title'         => 'Campaign Role \':role\'',
        ],
        'title'         => 'Campaign :name Roles',
        'types'         => [
            'owner'     => 'Admin',
            'public'    => 'Public',
            'standard'  => 'Standard',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Add a member',
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
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Enable',
        ],
        'boosted'       => 'This feature is in early access and currently only available for :boosted.',
        'description'   => 'Enable or disable modules of the campaign.',
        'edit'          => [
            'success'   => 'Campaign settings updated.',
        ],
        'helper'        => 'All modules of a campaign can be enabled or disabled at will. Disabling a module will simply hide interface elements related to it, and pre-existing entities will be hidden but still exist in the background, in case you change your mind. These change effect all users of a campaign, including Admin users.',
        'helpers'       => [
            'abilities'     => 'Create abilities, be it feats, spells, or powers that can be assigned to entities.',
            'calendars'     => 'A place to define the calendars of your world.',
            'characters'    => 'The people who inhabit your world.',
            'conversations' => 'Fictional conversations between characters or between campaign users. This module is deprecated.',
            'dice_rolls'    => 'For those who use Kanka for RPG campaigns, a way to handle dice rolls. This module is deprecated.',
            'events'        => 'Holidays, festivals, disasters, birthdays, wars.',
            'families'      => 'Clans or families, their relations and their members.',
            'items'         => 'Weapons, vehicles, relics, potions.',
            'journals'      => 'Observations written by characters, or session prep for the dungeon master.',
            'locations'     => 'Planets, planes, continents, rivers, states, settlements, temples, taverns.',
            'maps'          => 'Upload maps with layers and markers pointing to other entities in the campaign.',
            'menu_links'    => 'Custom menu links in the side bar.',
            'notes'         => 'Lore, religions, history, magic, races.',
            'organisations' => 'Cults, military units, factions, guilds.',
            'quests'        => 'To keep track of various quests with characters and locations.',
            'races'         => 'If your campaign has more than one race, this will make keeping track easy.',
            'tags'          => 'Each entity can have several tags. Tags can belong to other tags, and entries can be filtered by tag.',
            'timelines'     => 'Represent the history of your world with timelines.',
        ],
        'title'         => 'Campaign :name Modules',
    ],
    'show'                              => [
        'actions'       => [
            'boost' => 'Boost campaign',
            'edit'  => 'Edit Campaign',
            'leave' => 'Leave campaign',
        ],
        'description'   => 'A detailed view of a campaign',
        'tabs'          => [
            'default-images'    => 'Default Images',
            'export'            => 'Export',
            'information'       => 'Information',
            'members'           => 'Members',
            'menu'              => 'Menu',
            'plugins'           => 'Plugins',
            'recovery'          => 'Recovery',
            'roles'             => 'Roles',
            'settings'          => 'Modules',
        ],
        'title'         => 'Campaign :name',
    ],
    'ui'                                => [
        'helper'    => 'Use these settings to change the way some elements will be displayed in the campaign.',
    ],
    'visibilities'                      => [
        'private'   => 'Private',
        'public'    => 'Public',
        'review'    => 'Awaiting Review',
    ],
];
