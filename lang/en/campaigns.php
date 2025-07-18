<?php

return [
    'create'                            => [
        'success'   => ':name created.',
        'title'     => 'New Campaign',
    ],
    'edit'                              => [
        'success'   => ':name updated.',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'New characters have their personality private by default.',
    ],
    'entity_visibilities'               => [
        'private'   => 'New entities are private',
    ],
    'errors'                            => [
        'access'        => 'You don\'t have access to this campaign.',
        'premium'       => 'This feature is only available to premium campaigns.',
        'unknown_id'    => 'Unknown Campaign.',
    ],
    'exports'                           => [],
    'fields'                            => [
        'boosted'                           => 'Boosted by',
        'character_personality_visibility'  => 'Default character personality visibility',
        'connections'                       => 'Show an entity\'s connection table by default (instead of connections map for premium campaigns)',
        'css'                               => 'CSS',
        'description'                       => 'Description',
        'entity_count'                      => 'Entity Count',
        'entity_privacy'                    => 'Default new entity privacy',
        'entry'                             => 'Description of the world',
        'excerpt'                           => 'Dashboard description',
        'followers'                         => 'Followers',
        'gallery_visibility'                => 'Default Gallery Image Visibility',
        'genre'                             => 'Genre(s)',
        'header_image'                      => 'Dashboard background image',
        'image'                             => 'Sidebar image',
        'is_discreet'                       => 'Discreet',
        'locale'                            => 'Locale',
        'name'                              => 'Name',
        'open'                              => 'Open to applications',
        'post_collapsed'                    => 'New posts on entities are collapsed by default.',
        'premium'                           => 'Premium unlocked by :name',
        'private_mention_visibility'        => 'Private mentions',
        'public'                            => 'Campaign visibility',
        'public_campaign_filters'           => 'Public Filters',
        'related_visibility'                => 'Related Elements Visibility',
        'superboosted'                      => 'Superboosted by',
        'system'                            => 'System',
        'theme'                             => 'Theme',
        'vanity'                            => 'Vanity URL',
        'visibility'                        => 'Visibility',
    ],
    'following'                         => 'Following',
    'helpers'                           => [
        'boosted'                           => 'Some features are unlocked because this campaign is being boosted. Find out more on the :settings page.',
        'character_personality_visibility'  => 'When creating a new character as an admin, select the default privacy setting for its personality traits.',
        'css'                               => 'Write your own CSS that will be loaded into the pages of your campaign. Please note that any abuse of this feature can lead to a removal of your custom CSS. Repeated or grave offenses can lead to a removal of your campaign.',
        'dashboard'                         => 'Customise the way the campaign dashboard widget is displayed by filling out the following fields.',
        'entity_count_v3'                   => 'This number is recalculated every :amount hours.',
        'entity_privacy'                    => 'When creating a new entity as an admin, select the default privacy setting of the new entity.',
        'excerpt'                           => 'The contents of this field will be displayed on the dashboard in the campaign header widget, so write a few sentences introducing your world. If this field is empty, the first 1000 characters of the campaign\'s description field will be used instead.',
        'gallery_visibility'                => 'Default Visibility value when uploading images to the gallery.',
        'header_image'                      => 'Image displayed as a background in the campaign header dashboard widget.',
        'hide_history'                      => 'If enabled, only members of the campaign\'s :admin role will have access to an entity\'s history (log of changes).',
        'hide_members'                      => 'If enabled, only members of the campaign\'s :admin role will have access to the list of the campaign\'s members.',
        'is_discreet'                       => 'If enabled when the campaign is public, it won\'t be displayed in the :public-campaigns.',
        'is_discreet_locked'                => 'Premium campaigns can be set to be publicly visible but not show up in the :public-campaigns.',
        'locale'                            => 'The language your campaign is written in. This is used for generating content and grouping public campaigns.',
        'name'                              => 'Your campaign/world can have any name as long as it contains at least 4 letters or numbers.',
        'no_entry'                          => 'Looks like the campaign doesn\'t have a description yet! Let\'s fix that.',
        'permissions_tab'                   => 'Control the default privacy and visibility settings of new elements with the following options.',
        'premium'                           => 'Some features require premium features te be unlocked. Find out more about :settings.',
        'private_mention_visibility'        => 'Control if mentions to private entities are kept secret or show their names.',
        'public_campaign_filters'           => 'Help others find the campaign among other public campaigns by providing the following information.',
        'public_no_visibility'              => 'Heads up! The campaign is public, but the campaign\'s public role can\'t access anything. :fix.',
        'related_visibility'                => 'Default Visibility value when creating a new element with this field (posts, connections, abilities, etc)',
        'system'                            => 'If your campaign is publicly visible, the system is shown in the :link page.',
        'systems'                           => 'To avoid cluttering users with options, some features of Kanka are only available with specific RPG systems (ie the D&D 5e monster stat block). Adding supported systems here will enable those features.',
        'theme'                             => 'Force the theme for the campaign, overriding a user\'s preference.',
        'view_public'                       => 'To view your campaign as a public viewer would, open :link in an incognito window.',
        'visibility'                        => 'Making a campaign public will mean anyone with a link to it will be able to see it.',
    ],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'Copy the link to your clipboard',
            'link'  => 'Invite people',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Generate link',
            ],
            'success_link'  => 'Link created: :link',
            'title'         => 'Invite friends to :campaign',
        ],
        'destroy'               => [
            'success'   => 'Invitation removed.',
        ],
        'error'                 => [
            'inactive_token'    => 'This token has already been used, or the campaign no longer exists.',
            'invalid_token'     => 'This token is no longer valid.',
            'join'              => 'Please log in or register a new account to join :campaign.',
        ],
        'fields'                => [
            'created'   => 'Created',
            'role'      => 'Role',
            'token'     => 'Token',
            'type'      => 'Type',
            'usage'     => 'Expires after',
        ],
        'helpers'               => [
            'role'  => 'Users need to join before they can be promoted to the admin role.',
            'usage' => 'How many times the invite link can be used before it becomes inactive.',
        ],
        'unlimited_validity'    => 'Unlimited',
        'usages'                => [
            'five'      => '5 uses',
            'no_limit'  => 'Never',
            'once'      => '1 use',
            'ten'       => '10 uses',
        ],
    ],
    'leave'                             => [
        'action'            => 'Leave the campaign',
        'confirm'           => 'Are you sure you want to leave :name? You won\'t be able to access it anymore, unless one of it\'s admins invites you again.',
        'confirm-button'    => 'Yes, leave now',
        'error'             => 'Can\'t leave the campaign.',
        'fix'               => 'Go to the members management',
        'no-admin-left'     => 'Leaving the campaign isn\'t possible because doing so would leave it without any admins. Add another member to the admin role first.',
        'success'           => 'You have left :name.',
        'title'             => 'Leaving the campaign',
    ],
    'members'                           => [
        'actions'               => [
            'remove'        => 'Remove from campaign',
            'switch'        => 'View campaign as user',
            'switch-back'   => 'Back to my account',
            'switch-entity' => 'View as',
        ],
        'fields'                => [
            'banned'        => 'User is banned',
            'joined'        => 'Joined',
            'last_login'    => 'Last Login',
            'name'          => 'User',
            'role'          => 'Role',
            'roles'         => 'Roles',
        ],
        'helpers'               => [
            'switch'    => 'View the campaign as this member',
        ],
        'impersonating'         => [
            'message'   => 'You are viewing and interacting with :campaign as :name. Some features have been disabled, but the rest acts exactly as they would see it.',
            'title'     => 'Impersonating :name',
        ],
        'invite'                => [
            'description'   => 'Invite friends and players to :campaign by creating an invitation link and sending them the generated URL! Upon accepting their invitation, they will be added as a member in the invitation\'s requested role.',
            'more'          => 'More roles can be created on the :link page.',
            'title'         => 'Invites',
        ],
        'removal'               => 'You are removing ":member" from the campaign.',
        'roles'                 => [
            'member'    => 'Member',
            'owner'     => 'Admin',
            'player'    => 'Player',
            'public'    => 'Public',
            'viewer'    => 'Viewer',
        ],
        'switch_back_success'   => 'Switched back to your account.',
    ],
    'mentions'                          => [
        'private'   => 'Hide target name',
        'visible'   => 'Show target name',
    ],
    'modules'                           => [
        'permission-disabled'   => 'This module is disabled.',
    ],
    'overview'                          => [
        'entity-count'      => '{0} No entities|{1} :amount entity|[2,*] :amount entities',
        'follower-count'    => '{0} No followers|{1} :amount follower|[2,*] :amount followers',
    ],
    'panels'                            => [
        'dashboard' => 'Dashboard',
        'permission'=> 'Permission',
        'setup'     => 'Setup',
        'sharing'   => 'Sharing',
        'systems'   => 'Systems',
        'ui'        => 'Interface',
    ],
    'placeholders'                      => [
        'locale'    => 'Language code',
        'name'      => 'The name of your world',
        'system'    => 'D&D, Pathfinder, Fate, DSA',
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
            'add'           => 'New role',
            'duplicate'     => 'Duplicate role',
            'permissions'   => 'Manage permissions',
            'rename'        => 'Rename role',
            'save'          => 'Save role',
        ],
        'admin_role'    => 'admin role',
        'bulks'         => [
            'delete'    => '{1} Removed :count role.|[2,*] Removed :count roles.',
            'edit'      => '{1} Updated :count role.|[2,*] Updated :count roles.',
        ],
        'create'        => [
            'success'   => 'Role :name created.',
            'title'     => 'New role',
        ],
        'destroy'       => [
            'success'   => 'Role :name removed.',
        ],
        'edit'          => [
            'success'   => 'Role :name updated.',
            'title'     => 'Rename role :name',
        ],
        'fields'        => [
            'copy_permissions'  => 'Copy permissions',
            'name'              => 'Name',
            'permissions'       => 'Permissions',
            'type'              => 'Type',
            'users'             => 'Users',
        ],
        'helper'        => [
            '1'                     => 'A campaign is split up into several roles. The :admin role automatically has access to everything in a campaign, but every other role can have specific permissions on different types of entities (character, location, etc).',
            '2'                     => 'Entities can have more fine-tuned permissions by viewing the "Permissions" tab of an entity. This tab appears once your campaign has several roles or members.',
            '3'                     => 'One can either go with an "opt-out" system, where roles are given access to viewing all of the entities, and use the "Private" checkbox on entities to hide them. Or one can not give roles many permissions, but set each entity to be visible individually.',
            '4'                     => 'Premium campaigns can have an unlimited amount of roles.',
            'permissions_helper'    => 'Duplicate all of the role\'s permissions, on both modules and entities.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'The public role has permissions but the campaign is private. You can change this setting on the Sharing tab when editing the campaign.',
            'empty_role'            => 'The role doesn\'t have any members in it yet.',
            'role_admin'            => 'Members of the :name role can automatically access every entity and feature in the campaign.',
            'role_permissions'      => 'Use this interface to allow the :name role to do the following actions on all entities.',
        ],
        'members'       => 'Members',
        'modals'        => [
            'details'   => [
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
                'gallery'       => [
                    'browse'    => 'Browse',
                    'manage'    => 'Full control',
                    'upload'    => 'Upload',
                ],
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
                'entity_note'   => 'Allows adding, editing, and deleting posts even if the member can\'t edit the entity.',
                'gallery'       => [
                    'browse'    => 'Allow viewing the gallery, and setting an entity\'s image from the gallery.',
                    'manage'    => 'Allow everything on the gallery as an admin can, including editing and deleting images.',
                    'upload'    => 'Allows uploading images to the gallery. Will only see images they have uploaded if not combined with the browse permission.',
                ],
                'manage'        => 'Allow editing the campaign as an admin would, without allowing the members to delete the campaign.',
                'members'       => 'Allow inviting new members to the campaign.',
                'not_public'    => 'The campaign isn\'t public. Permissions for the public role can be set, but will be ignored. Go and edit the campaign to make it public.',
                'permission'    => 'Allow setting permissions on entities of this type they can edit.',
                'read'          => 'Allow viewing all entities of this type that aren\'t private.',
            ],
        ],
        'placeholders'  => [
            'name'  => 'Name of the role',
        ],
        'title'         => 'Roles - :name',
        'types'         => [
            'owner'     => 'Admin',
            'public'    => 'Public',
            'standard'  => 'Standard',
        ],
        'users'         => [
            'actions'   => [
                'add'           => 'Add member',
                'remove'        => ':user from the :role role',
                'remove_user'   => 'Remove member from role',
            ],
            'create'    => [
                'success'   => ':user added to the role :role.',
                'title'     => 'Add a member to the :name role',
            ],
            'destroy'   => [
                'success'   => ':user removed from the role :role.',
            ],
            'errors'    => [
                'cant_kick_admins'  => 'To avoid abuse, it is not possible to remove other members from the :admin role. In case of issues, contact us on :discord or at :email.',
                'needs_more_roles'  => 'You need to add yourself to another role in the campaign before being able to remove yourself from the :admin role.',
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
        'deprecated'    => [
            'help'  => 'This module is deprecated, meaning it is no longer maintained, and that bugs aren\'t tested with each new update. Use this module with the knowledge that it will eventually get removed from Kanka.',
            'title' => 'Deprecated',
        ],
        'disabled'      => 'The :module module is disabled.',
        'enabled'       => 'The :module module is enabled.',
        'errors'        => [
            'module-disabled'   => 'The requested module is currently disabled in the settings. :fix.',
        ],
        'helpers'       => [
            'abilities'         => 'Create abilities, be it feats, spells, or powers that can be assigned to entities.',
            'assets'            => 'Upload files, set links, and define aliases to individual entities.',
            'bookmarks'         => 'Create bookmarks to entities or filtered lists that appear in the sidebar.',
            'calendars'         => 'A place to define the calendars of the world.',
            'characters'        => 'Create and keep track of the people inhabiting the world with characters.',
            'conversations'     => 'Fictional conversations between characters or between members.',
            'creatures'         => 'Build your world\'s creatures, animals, and monsters with the creatures module.',
            'dice_rolls'        => 'For those who use Kanka for RPG games, a way to handle dice rolls.',
            'entity_attributes' => 'Keep track of attributes on entities of the world, for example HP or SPEED.',
            'events'            => 'Holidays, festivals, disasters, birthdays, wars.',
            'families'          => 'Clans or families, their relations and their members.',
            'inventories'       => 'Manage inventories on your entities.',
            'items'             => 'Weapons, vehicles, relics, potions.',
            'journals'          => 'Observations written by characters, or session prep for the dungeon master.',
            'locations'         => 'Planets, planes, continents, rivers, states, settlements, temples, taverns.',
            'maps'              => 'Create rich and beautiful maps with markers linking to the world\'s entities.',
            'notes'             => 'Lore, nature, history, magic, cultures.',
            'organisations'     => 'Cults, religions, factions, guilds.',
            'quests'            => 'To keep track of various quests with characters and locations.',
            'races'             => 'Track the origins, ethnicities, and racial traits of the world\'s characters with the race module.',
            'tags'              => 'Each entity can have several tags. Tags can belong to other tags, and entries can be filtered by tag.',
            'timelines'         => 'Represent the history of your world with timelines.',
        ],
    ],
    'sharing'                           => [
        'filters'   => 'Public campaigns are visible on the :public-campaigns page. Filling out these fields makes it easier for others to discover it.',
        'language'  => 'The main language in which your content is written.',
        'system'    => 'If playing a TTRPG, the system used to play.',
    ],
    'show'                              => [
        'actions'   => [
            'edit'  => 'Edit campaign',
        ],
        'tabs'      => [
            'achievements'      => 'Achievements',
            'applications'      => 'Applications',
            'customisation'     => 'Customisation',
            'danger'            => 'Danger',
            'data'              => 'Data',
            'default-images'    => 'Default thumbnails',
            'deletion'          => 'Deletion',
            'export'            => 'Export',
            'import'            => 'Import',
            'logs'              => 'Logs',
            'management'        => 'Management',
            'members'           => 'Members',
            'modules'           => 'Modules',
            'plugins'           => 'Plugins',
            'recovery'          => 'Recovery',
            'roles'             => 'Roles',
            'sidebar'           => 'Sidebar',
            'stats'             => 'Stats',
            'styles'            => 'Theming',
            'webhooks'          => 'Webhooks',
        ],
        'title'     => 'Overview - :name',
    ],
    'status'                            => [
        'free'      => 'Premium features disabled.',
        'legacy'    => [
            'title' => 'Boosted features (legacy)',
        ],
        'premium'   => 'Premium features unlocked by :name.',
        'title'     => 'Premium features',
    ],
    'themes'                            => [
        'none'  => 'None (defaults to user\'s preference)',
    ],
    'ui'                                => [
        'collapsed'         => [
            'collapsed' => 'Collapsed',
            'default'   => 'Default',
        ],
        'connections'       => [
            'explorer'  => 'Connections map (if available, for premium campaigns)',
            'list'      => 'List interface',
        ],
        'descendants'       => [
            'all'       => 'Show all descendants by default',
            'direct'    => 'Show direct descendants by default',
        ],
        'entity_history'    => [
            'hidden'    => 'Only visible to campaign admins',
            'visible'   => 'Visible to members',
        ],
        'fields'            => [
            'connections'       => 'Default entity\'s connections interface',
            'connections_mode'  => 'Default connections map mode',
            'descendants'       => 'Descendants filtering',
            'entity_history'    => 'Entity\'s history logs',
            'member_list'       => 'Member list',
            'post_collapsed'    => 'New post default collapsed value',
        ],
        'helpers'           => [
            'connections'       => 'When clicking on the connections subpage of an entity, select the default interface showed.',
            'connections_mode'  => 'When viewing the connections map of an entity, define the default mode that is selected.',
            'descendants'       => 'Control the default filtering when loading a sublist. For example a location\'s characters.',
            'entity-history'    => 'Control who can see recent changes made to individual entities of the campaign.',
            'member-list'       => 'Control who can see who\'s in the campaign.',
            'other'             => 'Other visual options for the campaign.',
            'post_collapsed'    => 'When creating a new post on an entity, select the collapsed field\'s default value.',
            'theme'             => 'Display the campaign in the member\'s theme, or force it to render in one of the following themes.',
        ],
        'members'           => [
            'hidden'    => 'Only visible to campaign admins',
            'visible'   => 'Visible to members',
        ],
        'other'             => 'Other',
    ],
    'visibilities'                      => [
        'private'   => 'Private campaign',
        'public'    => 'Public campaign',
        'review'    => 'Awaiting Review',
    ],
];
