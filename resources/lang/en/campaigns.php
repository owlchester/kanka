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
        'action'    => 'Delete campaign',
        'helper'    => 'You can only delete the campaign if you are the only member in it.',
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
        'superboosted'  => 'This feature is only available to superboosted campaigns.',
        'unknown_id'    => 'Unknown Campaign.',
    ],
    'export'                            => [
        'description'       => 'Export the campaign.',
        'errors'            => [
            'limit' => 'You have exceeded your maximum of one exports per day. Please try again tomorrow.',
        ],
        'helper'            => 'Export your campaign. A notification with a download link will be made available.',
        'helper_secondary'  => 'Two files will be made available, one with the entities exported as JSON, and another with images uploaded to entities. Please note that on larger campaigns, the images export crashes and can only be recovered using the :api.',
        'success'           => 'Your campaign export is being prepared. You\'ll receive a notification in Kanka to a downloadable zip as soon as it\'s ready.',
        'title'             => 'Campaign :name Export',
    ],
    'fields'                            => [
        'boosted'                       => 'Boosted by',
        'connections'                   => 'Show an entity\'s connection table by default (instead of relation explorer for boosted campaigns)',
        'css'                           => 'CSS',
        'description'                   => 'Description',
        'entity_count'                  => 'Entity Count',
        'entry'                         => 'Campaign description',
        'excerpt'                       => 'Campaign dashboard text',
        'followers'                     => 'Followers',
        'header_image'                  => 'Campaign dashboard background image',
        'hide_history'                  => 'Hide entity history',
        'hide_members'                  => 'Hide campaign members',
        'image'                         => 'Image',
        'locale'                        => 'Locale',
        'name'                          => 'Name',
        'nested'                        => 'Default entity lists to nested when available',
        'open'                          => 'Open to applications',
        'public_campaign_filters'       => 'Public Campaign Filters',
        'related_visibility'            => 'Related Elements Visibility',
        'rpg_system'                    => 'RPG Systems',
        'superboosted'                  => 'Superboosted by',
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
        'dashboard'                     => 'Customise the way the campaign dashboard widget is displayed by filling out the following fields.',
        'excerpt'                       => 'The contents of this field will be displayed on the dashboard in the campaign header widget, so write a few sentences introducing your world. If this field is empty, the first 1000 characters of the campaign\'s entry field will be used instead.',
        'header_image'                  => 'Image displayed as a background in the campaign header dashboard widget.',
        'hide_history'                  => 'Enable this option to hide the history of entities to non-admin members of the campaign.',
        'hide_members'                  => 'Enable this option to hide the campaign member list of the campaign to non-admin members.',
        'locale'                        => 'The language your campaign is written in. This is used for generating content and grouping public campaigns.',
        'name'                          => 'Your campaign/world can have any name as long as it contains at least 4 letters or numbers.',
        'public_campaign_filters'       => 'Help others find the campaign among other public campaigns by providing the following information.',
        'public_no_visibility'          => 'Heads up! Your campaign is public, but the campaign\'s public role can\'t access anything. :fix.',
        'related_visibility'            => 'Default Visibility value when creating a new element with this field (posts, relations, abilities, etc)',
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
            'add'   => 'Email invite',
            'copy'  => 'Copy the link to your clipboard',
            'link'  => 'New Link',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Create invite',
                'send'      => 'Send invite',
            ],
            'description'   => 'Invite a friend to your campaign',
            'success'       => 'Invitation sent.',
            'success_link'  => 'Link created: :link',
            'title'         => 'Invite someone to your campaign',
        ],
        'destroy'               => [
            'success'   => 'Invitation removed.',
        ],
        'email'                 => [
            'link_text' => 'Join :name\'s campaign',
            'subject'   => ':name has invited you to join their \':campaign\' campaign on kanka.io! Use the following link to accept their invitation.',
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
            'email'     => 'Our emails are often flagged as spam and can take up to a few hours before appearing in the inbox.',
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
            'switch'        => 'View as',
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
            'admin' => 'As a member of the campaign\'s admin role, you can invite new users, remove inactive one, and change their permissions. To test the permissions of a member, use the :button button. You can read more about this feature in the :link.',
            'switch'=> 'View the campaign as this user',
        ],
        'impersonating'         => [
            'message'   => 'You are viewing the campaign as another user. Some features have been disabled, but the rest acts exactly as the user would see it.',
            'title'     => 'Impersonating :name',
        ],
        'invite'                => [
            'description'   => 'You can invite friends to join your campaign by providing them with an Invite Link. Upon accepting their invitation, they will be added as a member in the requested role. You can also send them a request by email.',
            'more'          => 'You can add more roles on the :link.',
            'roles_page'    => 'Roles page',
            'title'         => 'Invite',
        ],
        'manage_roles'          => 'Manage user roles',
        'roles'                 => [
            'member'    => 'Member',
            'owner'     => 'Admin',
            'player'    => 'Player',
            'public'    => 'Public',
            'viewer'    => 'Viewer',
        ],
        'switch_back_success'   => 'Switched back to your account.',
        'title'                 => 'Campaign :name Members',
        'updates'               => [
            'added'     => 'Role :role added to :user.',
            'removed'   => 'Role :role removed from :user.',
        ],
        'your_role'             => 'Your role: <i>:role</i>',
    ],
    'open_campaign'                     => [
        'helper'    => 'A public campaign set as open will allow users to send applications to joining it. Find the list of applications on our :link page.',
        'link'      => 'campaign applications',
        'title'     => 'Open Campaign',
    ],
    'options'       => [
        'entity_visibility' => 'Automatically set newly created entities to private by default.',
        'entity_personality_visibility' => 'Automatically set new characters to have their personality private by default.',
    ],
    'panels'                            => [
        'boosted'   => 'Boosted',
        'dashboard' => 'Dashboard',
        'permission'=> 'Permission',
        'setup'     => 'Setup',
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
            'add'           => 'Add a role',
            'permissions'   => 'Manage permissions',
            'rename'        => 'Rename role',
        ],
        'admin_role'    => 'admin role',
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
        'modals'        => [
            'details'   => [
                'button'    => 'Need help',
                'campaign'  => 'Campaign permissions allow the following.',
                'entities'  => 'Here is a quick recap of what members of this role get when a permission is set.',
                'more'      => 'For more details, view our tutorial video on Youtube',
                'title'     => 'Permission details',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Create',
                'dashboard'     => 'Dashboard',
                'delete'        => 'Delete',
                'edit'          => 'Edit',
                'entity-note'   => 'Post',
                'manage'        => 'Manage',
                'members'       => 'Members',
                'permission'    => 'Permissions',
                'read'          => 'View',
                'toggle'        => 'Change for all',
            ],
            'helpers'   => [
                'add'           => 'Allow creating entities of this type. They will automatically be allowed to view and edit entities they create if they don\'t have the view or edit permission.',
                'dashboard'     => 'Allow editing the dashboards and dashboard widgets.',
                'delete'        => 'Allow removing all entities of this type.',
                'edit'          => 'Allow editing all entities of this type.',
                'entity_note'   => 'Allows adding and editing posts even if the member can\'t edit the entity.',
                'manage'        => 'Allow editing the campaign as a campaign admin would, without allowing the membres to delete the campaign.',
                'members'       => 'Allow inviting new members to the campaign.',
                'permission'    => 'Allow setting permissions on entities of this type they can edit.',
                'read'          => 'Allow viewing all entities of this type that aren\'t private.',
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
                'add'       => 'Add a member',
                'remove'    => ':user from the :role role',
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
            'inventories'   => 'Manage inventories on your entities.',
            'items'         => 'Weapons, vehicles, relics, potions.',
            'journals'      => 'Observations written by characters, or session prep for the dungeon master.',
            'locations'     => 'Planets, planes, continents, rivers, states, settlements, temples, taverns.',
            'maps'          => 'Upload maps with layers and markers pointing to other entities in the campaign.',
            'menu_links'    => 'Custom menu links in the side bar.',
            'notes'         => 'Lore, nature, history, magic, cultures.',
            'organisations' => 'Cults, religions, factions, guilds.',
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
        'menus'         => [
            'configuration'     => 'Configuration',
            'overview'          => 'Overview',
            'user_management'   => 'User management',
        ],
        'tabs'          => [
            'achievements'      => 'Achievements',
            'applications'      => 'Applications',
            'campaign'          => 'Campaign',
            'default-images'    => 'Default Images',
            'export'            => 'Export',
            'information'       => 'Information',
            'members'           => 'Members',
            'menu'              => 'Menu',
            'plugins'           => 'Plugins',
            'recovery'          => 'Recovery',
            'roles'             => 'Roles',
            'settings'          => 'Modules',
            'styles'            => 'CSS Styling',
        ],
        'title'         => 'Campaign :name',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Uploading images in the text editor is a feature only available to :superboosted.',
                'title' => 'Campaign Gallery Image Upload',
            ],
        ],
    ],
    'ui'                                => [
        'helper'    => 'Use these settings to change the way some elements will be displayed in the campaign.',
        'other'     => 'Other',
    ],
    'visibilities'                      => [
        'private'   => 'Private',
        'public'    => 'Public',
        'review'    => 'Awaiting Review',
    ],
];
