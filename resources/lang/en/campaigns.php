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
        'success'   => 'Campaign updated.',
        'title'     => 'Edit Campaign :campaign',
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
        'errors'            => [
            'limit' => 'You have exceeded your maximum of one exports per day. Please try again tomorrow.',
        ],
        'helper'            => 'Export your campaign. A notification with a download link will be made available.',
        'helper_secondary'  => 'Two files will be made available, one with the entities exported as JSON, and another with images uploaded to entities. Please note that on larger campaigns, the images export crashes and can only be recovered using the :api.',
        'helper_third'      => 'JSON files can be opened with any text file application. They represent the data stored in the Kanka database in a text format. There is no way to import your export back into Kanka.',
        'success'           => 'Your campaign export is being prepared. You\'ll receive a notification in Kanka to a downloadable zip as soon as it\'s ready.',
        'title'             => 'Campaign :name Export',
    ],
    'fields'                            => [
        'boosted'                           => 'Boosted by',
        'character_personality_visibility'  => 'Default character personality visibility',
        'connections'                       => 'Show an entity\'s connection table by default (instead of relation explorer for boosted campaigns)',
        'css'                               => 'CSS',
        'description'                       => 'Description',
        'entity_count'                      => 'Entity Count',
        'entity_privacy'                    => 'Default new entity privacy',
        'entry'                             => 'Campaign description',
        'excerpt'                           => 'Campaign dashboard text',
        'featured'                          => 'Featured campaign',
        'followers'                         => 'Followers',
        'header_image'                      => 'Campaign dashboard background image',
        'image'                             => 'Image',
        'locale'                            => 'Locale',
        'name'                              => 'Name',
        'nested'                            => 'Default entity lists to nested when available',
        'open'                              => 'Open to applications',
        'past_featured'                     => 'Previously featured campaign',
        'post_collapsed'                    => 'New posts on entities are collapsed by default.',
        'public'                            => 'Campaign visibility',
        'public_campaign_filters'           => 'Public Campaign Filters',
        'related_visibility'                => 'Related Elements Visibility',
        'rpg_system'                        => 'RPG Systems',
        'superboosted'                      => 'Superboosted by',
        'system'                            => 'System',
        'theme'                             => 'Theme',
        'visibility'                        => 'Visibility',
    ],
    'following'                         => 'Following',
    'helpers'                           => [
        'boost_required'                    => 'This feature requires the campaign to be boosted. More info on the :settings page.',
        'boost_required_multi'              => 'These features require the campaign to be boosted. More info on the :settings page.',
        'boosted'                           => 'Some features are unlocked because this campaign is being boosted. Find out more on the :settings page.',
        'character_personality_visibility'  => 'When creating a new character as an admin, select the default privacy setting for its personality traits.',
        'css'                               => 'Write your own CSS that will be loaded into the pages of your campaign. Please note that any abuse of this feature can lead to a removal of your custom CSS. Repeated or grave offenses can lead to a removal of your campaign.',
        'dashboard'                         => 'Customise the way the campaign dashboard widget is displayed by filling out the following fields.',
        'entity_count'                      => 'This number updates every six hours.',
        'entity_privacy'                    => 'When creating a new entity as an admin, select the default privacy setting of the new entity.',
        'excerpt'                           => 'The contents of this field will be displayed on the dashboard in the campaign header widget, so write a few sentences introducing your world. If this field is empty, the first 1000 characters of the campaign\'s entry field will be used instead.',
        'header_image'                      => 'Image displayed as a background in the campaign header dashboard widget.',
        'hide_history'                      => 'If enabled, only members of the campaign\'s :admin role will have access to an entity\'s history (log of changes).',
        'hide_members'                      => 'If enabled, only members of the campaign\'s :admin role will have access to the list of the campaign\'s members.',
        'locale'                            => 'The language your campaign is written in. This is used for generating content and grouping public campaigns.',
        'name'                              => 'Your campaign/world can have any name as long as it contains at least 4 letters or numbers.',
        'permissions_tab'                   => 'Control the default privacy and visibility settings of new elements with the following options.',
        'public_campaign_filters'           => 'Help others find the campaign among other public campaigns by providing the following information.',
        'public_no_visibility'              => 'Heads up! The campaign is public, but the campaign\'s public role can\'t access anything. :fix.',
        'related_visibility'                => 'Default Visibility value when creating a new element with this field (posts, relations, abilities, etc)',
        'system'                            => 'If your campaign is publicly visible, the system is shown in the :link page.',
        'systems'                           => 'To avoid cluttering users with options, some features of Kanka are only available with specific RPG systems (ie the D&D 5e monster stat block). Adding supported systems here will enable those features.',
        'theme'                             => 'Force the theme for the campaign, overriding a user\'s preference.',
        'view_public'                       => 'To view your campaign as a public viewer would, open :link in an incognito window.',
        'visibility'                        => 'Making a campaign public will mean anyone with a link to it will be able to see it.',
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
            'link'  => 'Invite people',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Generate link',
                'send'      => 'Send invite',
            ],
            'success'       => 'Invitation sent.',
            'success_link'  => 'Link created: :link',
            'title'         => 'Invite friends to :campaign',
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
            'usage'     => 'Max number of uses',
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
        'usages'                => [
            'five'      => '5 uses',
            'no_limit'  => 'No limit',
            'once'      => '1 use',
            'ten'       => '10 uses',
        ],
    ],
    'leave'                             => [
        'confirm'   => 'Are you sure you want to leave the :name campaign? You won\'t be able to access it anymore, unless an admin of the campaign invites you again.',
        'error'     => 'Can\'t leave the campaign.',
        'success'   => 'You have left the campaign.',
    ],
    'members'                           => [
        'actions'               => [
            'help'          => 'Help',
            'remove'        => 'Remove from campaign',
            'switch'        => 'View campaign as user',
            'switch-back'   => 'Back to my user',
        ],
        'create'                => [
            'title' => 'Add a member to your campaign',
        ],
        'edit'                  => [
            'title' => 'Edit member :name',
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
            'description'   => 'Invite your friends and players to the campaign by creating an invitation link and sending them the generated URL! Upon accepting their invitation, they will be added as a member in the invitation\'s requested role.',
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
        'helper'    => 'A public campaign that is open to applications will allow users to send an application to join it through the campaign\'s dashboard. Find the list of applications in the campaign\'s :link page.',
        'link'      => 'campaign applications',
        'statuses'  => [
            'closed'    => 'Closed',
            'open'      => 'Open to applications',
        ],
        'title'     => 'Applications',
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
    'privacy'                           => [
        'hidden'    => 'Hidden',
        'private'   => 'Private',
        'visible'   => 'Visible',
    ],
    'public'                            => [
        'helpers'   => [
            'introduction'  => 'Campaigns are private by default, and can be made public. This allows anyone to access them, and makes them available in the :public-campaigns page if they have entities visible to the :public-role role. A public campaign is visible to all, but for its content to be visible, the :public-role role needs adequate permissions.',
        ],
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Create role',
            'permissions'   => 'Manage permissions',
            'rename'        => 'Rename role',
            'save'          => 'Save role',
        ],
        'admin_role'    => 'admin role',
        'create'        => [
            'success'   => 'Role :name created.',
            'title'     => 'New role',
        ],
        'destroy'       => [
            'success'   => 'Role :name removed.',
        ],
        'edit'          => [
            'success'   => 'Role :name updated.',
            'title'     => 'Edit role :name',
        ],
        'fields'        => [
            'name'          => 'Name',
            'permissions'   => 'Permissions',
            'type'          => 'Type',
            'users'         => 'Users',
        ],
        'helper'        => [
            '1' => 'A campaign can have as many roles as wanted. The :admin role automatically has access to everything in a campaign, but every other role can have specific permissions on different types of entities (character, location, etc).',
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
                'gallery'       => 'Gallery',
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
                'gallery'       => 'Allow managing the superboosted campaign\'s gallery.',
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
            'title' => 'Campaign Role \':role\'',
        ],
        'title'         => 'Campaign :name Roles',
        'types'         => [
            'owner'     => 'Admin',
            'public'    => 'Public',
            'standard'  => 'Standard',
        ],
        'users'         => [
            'actions'   => [
                'add'       => 'Add member',
                'remove'    => ':user from the :role role',
            ],
            'create'    => [
                'success'   => ':user added to the role :role.',
                'title'     => 'Add a member to the :name role',
            ],
            'destroy'   => [
                'success'   => ':user removed from the role :role.',
            ],
            'fields'    => [
                'name'  => 'Name',
            ],
        ],
    ],
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Enable',
        ],
        'boosted'   => 'This feature is in early access and currently only available for :boosted.',
        'edit'      => [
            'success'   => 'Campaign settings updated.',
        ],
        'errors'    => [
            'module-disabled'   => 'The requested module is currently disabled in the campaign settings. :fix.',
        ],
        'helper'    => 'All modules of a campaign can be enabled or disabled at will. Disabling a module will simply hide interface elements related to it, and pre-existing entities will be hidden but still exist in the background, in case you change your mind. These change effect all users of a campaign, including members of the :admin role.',
        'helpers'   => [
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
        'title'     => 'Campaign :name Modules',
    ],
    'show'                              => [
        'actions'   => [
            'boost' => 'Boost campaign',
            'edit'  => 'Edit Campaign',
            'leave' => 'Leave campaign',
        ],
        'menus'     => [
            'configuration'     => 'Configuration',
            'overview'          => 'Overview',
            'user_management'   => 'User management',
        ],
        'tabs'      => [
            'achievements'      => 'Achievements',
            'applications'      => 'Applications',
            'campaign'          => 'Campaign',
            'default-images'    => 'Default Images',
            'export'            => 'Export',
            'information'       => 'Information',
            'members'           => 'Members',
            'plugins'           => 'Plugins',
            'recovery'          => 'Recovery',
            'roles'             => 'Roles',
            'settings'          => 'Modules',
            'sidebar'           => 'Sidebar setup',
            'styles'            => 'Theming',
        ],
        'title'     => 'Campaign :name',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Uploading images in the text editor is a feature only available to :superboosted.',
                'title' => 'Campaign Gallery Image Upload',
            ],
        ],
    ],
    'themes'                            => [
        'none'  => 'None (defaults to user settings)',
    ],
    'ui'                                => [
        'boosted'           => 'Boosted',
        'collapsed'         => [
            'collapsed' => 'Collapsed',
            'default'   => 'Default',
        ],
        'connections'       => [
            'explorer'  => 'Relations explorer (if available, for boosted campaigns)',
            'list'      => 'List interface',
        ],
        'entity_history'    => [
            'hidden'    => 'Only visible to campaign admins',
            'visible'   => 'Visible to members',
        ],
        'fields'            => [
            'connections'       => 'Default entity\'s connections interface',
            'entity_history'    => 'Entity\'s history logs',
            'entity_image'      => 'Entity\'s image',
            'family_toolip'     => 'Character\'s family',
            'member_list'       => 'Campaign\'s member list',
            'nested'            => 'Default lists layout',
            'post_collapsed'    => 'New post default collapsed value',
        ],
        'helpers'           => [
            'connections'       => 'When clicking on the connections subpage of an entity, select the default interface showed.',
            'other'             => 'Other visual options for the campaign.',
            'post_collapsed'    => 'When creating a new post on an entity, select the collapsed field\'s default value.',
            'tooltip'           => 'Control which information is visibile when hovering an entity\'s name in their tooltip.',
        ],
        'members'           => [
            'hidden'    => 'Only visible to campaign admins',
            'visible'   => 'Visible to members',
        ],
        'nested'            => [
            'default'   => 'Default',
            'nested'    => 'Nested',
        ],
        'other'             => 'Other',
    ],
    'visibilities'                      => [
        'private'   => 'Private',
        'public'    => 'Public',
        'review'    => 'Awaiting Review',
    ],
];
