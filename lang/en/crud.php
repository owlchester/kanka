<?php

return [
    'actions'                   => [
        'actions'           => 'Actions',
        'apply'             => 'Apply',
        'back'              => 'Back',
        'change'            => 'Change',
        'copy'              => 'Copy',
        'copy_mention'      => 'Copy [ ] mention',
        'copy_to_campaign'  => 'Copy to campaign',
        'disable'           => 'Disable',
        'enable'            => 'Enable',
        'explore_view'      => 'Nested View',
        'export'            => 'Export (PDF)',
        'find_out_more'     => 'Find out more',
        'go_to'             => 'Go to :name',
        'help'              => 'Help',
        'json-export'       => 'Export (JSON)',
        'manage_links'      => 'Manage Links',
        'markdown-export'   => 'Export (Markdown)',
        'move'              => 'Move',
        'new'               => 'New',
        'new_child'         => 'New child',
        'new_post'          => 'New post',
        'next'              => 'Next',
        'open'              => 'Open',
        'print'             => 'Print',
        'reorder'           => 'Reorder',
        'reset'             => 'Reset',
        'transform'         => 'Transform',
    ],
    'add'                       => 'Add',
    'alerts'                    => [
        'copy_attribute'    => 'The attribute\'s mention was copied to your clipboard.',
        'copy_invite'       => 'The campaign invite link was copied to your clipboard.',
        'copy_mention'      => 'The entity\'s advanced mention was copied to your clipboard.',
    ],
    'bulk'                      => [
        'actions'       => [
            'edit'          => 'Edit & tagging',
            'permissions'   => 'Change permissions',
            'templates'     => 'Apply attribute template',
        ],
        'age'           => [
            'helper'    => 'You can use + and - before the number to update the age by that amount.',
        ],
        'buttons'       => [
            'label' => 'For selected',
        ],
        'delete'        => [
            'warning'   => 'You are deleting multiple entities.',
        ],
        'edit'          => [
            'locations' => 'Action for locations',
            'tagging'   => 'Action for tags',
            'tags'      => [
                'add'       => 'Add',
                'remove'    => 'Remove',
            ],
            'title'     => 'Editing multiple entities',
        ],
        'errors'        => [
            'admin'     => 'Only campaign admins can change the private status of entities.',
            'general'   => 'An error occurred processing your action. Please try again and contact us if the problem persists. Error message: :hint.',
        ],
        'permissions'   => [
            'fields'    => [
                'override'  => 'Override',
            ],
            'helpers'   => [
                'override'  => 'If selected, permissions of the selected entities will be overwritten with these. If unchecked, the selected permissions will be added to the existing ones.',
            ],
            'title'     => 'Change permissions for several entities',
        ],
        'success'       => [
            'copy_to_campaign'  => '{1} :count entity copied to :campaign.|[2,*] :count entities copied to :campaign.',
            'editing'           => '{1} :count entity was updated.|[2,*] :count entities were updated.',
            'editing_partial'   => '{1} :count/:total entity was updated.|[2,*] :count/:total entities were updated.',
            'permissions'       => '{1} Permissions changed for :count entity.|[2,*] Permissions changed for :count entities.',
            'private'           => '{1} :count entity is now private.|[2,*] :count entities are now private.',
            'public'            => '{1} :count entity is now visible.|[2,*] :count entities are now visible.',
            'templates'         => '{1} :count entity had a template applied.|[2,*] :count entities has a template applied.',
        ],
    ],
    'bulk_templates'            => [
        'bulk_title'    => 'Apply a template to multiple entities',
    ],
    'cancel'                    => 'Cancel',
    'click_modal'               => [
        'close'     => 'Close',
        'confirm'   => 'Confirm',
        'title'     => 'Confirm your action',
    ],
    'copy_to_campaign'          => [
        'bulk_title'    => 'Copy entities to another campaign',
        'panel'         => 'Copy',
        'title'         => 'Copy \':name\' to another campaign',
    ],
    'create'                    => 'Create',
    'datagrid'                  => [
        'empty' => 'Nothing to show yet.',
    ],
    'delete_modal'              => [
        'callout'           => 'Psst!',
        'close'             => 'Close',
        'confirm'           => 'Confirm removal',
        'delete'            => 'Remove',
        'description_v2'    => 'You are removing ":tag".',
        'permanent'         => 'This action is permanent.',
        'recoverable'       => 'Entities can be recovered for up to :day days with a :boosted-campaign.',
        'title'             => 'Removal confirmation',
    ],
    'destroy_many'              => [
        'success'   => 'Deleted :count entity.|Deleted :count entities.',
    ],
    'edit'                      => 'Edit',
    'errors'                    => [
        'boosted'                       => 'This feature is only available to boosted campaigns.',
        'boosted_campaigns'             => 'This feature is only available for :boosted.',
        'invalid_node'                  => 'The selected parent is invalid. This can usually be fixed by giving the selected parent a parent of its own, then removing it.',
        'node_must_not_be_a_descendant' => 'The selected parent is invalid. It would be a descendant of itself.',
        'unavailable_feature'           => 'Unavailable feature',
    ],
    'fields'                    => [
        'calendar_date'     => 'Calendar Date',
        'child'             => 'Child',
        'closed'            => 'Closed',
        'colour'            => 'Colour',
        'copy_abilities'    => 'Copy Abilities',
        'copy_attributes'   => 'Copy Attributes',
        'copy_inventory'    => 'Copy Inventory',
        'copy_links'        => 'Copy Links',
        'copy_permissions'  => 'Copy Permissions (this will override values set in the permissions tab)',
        'copy_posts'        => 'Copy Posts (this includes the posts permissions)',
        'creator'           => 'Creator',
        'date_range'        => 'Date range',
        'entity'            => 'Entity',
        'entity_type'       => 'Entity Type',
        'entry'             => 'Entry',
        'excerpt'           => 'Excerpt',
        'files'             => 'Files',
        'gallery_header'    => 'Gallery Header',
        'gallery_image'     => 'Gallery Image',
        'has_attributes'    => 'Has attributes',
        'has_entity_files'  => 'Has entity files',
        'has_image'         => 'Has an image',
        'has_posts'         => 'Has posts',
        'header_image'      => 'Header Image',
        'image'             => 'Image',
        'is_closed'         => 'Conversation will be closed and will no longer accept new messages.',
        'is_private'        => 'Private',
        'is_private_v3'     => 'Only show this to members of the :admin-role role. This overrides any other permission.',
        'is_star'           => 'Pinned',
        'locations'         => ':first in :second',
        'name'              => 'Name',
        'parent'            => 'Parent',
        'position'          => 'Position',
        'privacy'           => 'Privacy',
        'replace_mentions'  => 'Replace attribute mentions in the entry with those of the new entity',
        'template'          => 'Template',
        'tooltip'           => 'Tooltip',
        'type'              => 'Type',
        'visibility'        => 'Visibility',
    ],
    'files'                     => [
        'actions'   => [
            'drop'      => 'Click to Add or Drop a file',
            'manage'    => 'Manage Entity Files',
        ],
        'errors'    => [
            'max'            => 'You have reached the maximum number (:max) of files for this entity.',
            'max_size'       => 'You have reached the maximum storage capacity for files of this campaign.',
            'no_files'       => 'No files.',
        ],
        'files'     => 'Uploaded Files',
        'hints'     => [
            'limit'         => 'Each entity can have a maximum of :max files uploaded to it.',
            'limitations'   => 'Supported formats: :formats. Max file size: :size.',
        ],
        'title'     => 'Entity Files for :name',
    ],
    'filter'                    => 'Filter',
    'filters'                   => [
        'all'                       => 'Filter to all descendants',
        'clear'                     => 'Clear Filters',
        'copy_helper'               => 'Use the copied filters in your clipboard as values for filters on dashboard widgets and bookmarks.',
        'copy_helper_no_filters'    => 'Define some filters first to be able to copy them to your clipboard.',
        'copy_to_clipboard'         => 'Copy filters to clipboard',
        'direct'                    => 'Filter to direct descendants',
        'filtered'                  => 'Showing :count of :total :entity.',
        'hide'                      => 'Hide Filters',
        'lists'                     => [
            'desktop'   => [
                'all'       => 'Show all descendants (:count)',
                'filtered'  => 'Show direct descendants (:count)',
            ],
            'mobile'    => [
                'all'       => 'Show all (:count)',
                'filtered'  => 'Show direct (:count)',
            ],
        ],
        'mobile'                    => [
            'clear' => 'Clear',
            'copy'  => 'Clipboard',
        ],
        'options'                   => [
            'children'  => 'Matches this or its descendants',
            'exclude'   => 'Doesn\'t match',
            'hide'      => 'Hide',
            'include'   => 'Matches',
            'none'      => 'Empty',
            'show'      => 'Show',
        ],
        'show'                      => 'Show Filters',
        'sorting'                   => [
            'asc'       => ':field Ascending',
            'desc'      => ':field Descending',
            'helper'    => 'Control in which order results appear.',
        ],
        'title'                     => 'Advanced filters',
    ],
    'fix-this-issue'            => 'Fix this issue',
    'forms'                     => [
        'actions'       => [
            'calendar'  => 'Add a calendar date',
        ],
        'copy_options'  => 'Copy Options',
    ],
    'helpers'                   => [
        'copy_options'  => 'Copy the following related elements from the source to the new entity.',
        'learn_more'    => 'Learn more about this feature in our :documentation.',
        'linking'       => 'Linking to other entities',
        'nested_parent' => 'Displaying the children of :parent.',
        'pagination'    => [
            'settings'  => 'appearance settings',
            'text'      => 'More results per page can be shown by changing your :settings.',
        ],
    ],
    'hidden'                    => 'Hidden',
    'hints'                     => [
        'attribute_template'    => 'The selected attribute template will be applied when saving the entity.',
        'calendar_date'         => 'A calendar date allows easy filtering in lists, and also maintains a reminder in the selected calendar.',
        'gallery_header'        => 'If the entity has no header, display an image from the campaign gallery instead.',
        'gallery_image'         => 'If the entity has no image, display an image from the campaign gallery instead.',
        'header_image'          => 'This image is placed above the entity. For best results, use a wide image.',
        'image_dimension'       => 'Recommended dimensions: :dimension pixels.',
        'image_limitations'     => 'Supported formats: :formats. Max file size: :size.',
        'image_recommendation'  => 'Recommended dimensions: :width by :height px.',
        'is_star'               => 'Pinned elements will appear on the entity\'s overview page.',
        'tooltip'               => 'Replace the automatically generated tooltip with the following contents. Any HTML code will be stripped, but you can still mention other entities using advanced mentions.',
        'visibility'            => 'Setting the visibility to admin means only members in the Admin campaign role can view this. Setting it to self means only you can view this.',
    ],
    'history'                   => [
        'created_clean'         => 'Created by :name :date',
        'created_date_clean'    => 'Created :date',
        'unknown'               => 'Unknown',
        'updated_clean'         => 'Last modified by :name :date',
        'updated_date_clean'    => 'Last modified :date',
        'view'                  => 'View entity log',
    ],
    'image'                     => [
        'error' => 'We weren\'t able to get the image you requested. It could be that the website doesn\'t allow us to download the image (typically for Squarespace and DeviantArt), or that the link is no longer valid. Please also make sure that the image isn\'t larger than :size.',
    ],
    'is_private'                => 'This entity is private and only visible to members of the campaign\'s Admin role.',
    'keyboard-shortcut'         => 'Keyboard shortcut :code',
    'legacy'                    => 'Legacy',
    'navigation'                => [
        'cancel'            => 'cancel',
        'or_cancel'         => 'or :cancel',
        'skip_to_content'   => 'Skip navigation',
    ],
    'permissions'               => [
        'action'            => 'Action',
        'actions'           => [
            'bulk'          => [
                'add'       => 'Allow',
                'deny'      => 'Deny',
                'ignore'    => 'Skip',
                'remove'    => 'Remove',
            ],
            'bulk_entity'   => [
                'allow'     => 'Allow',
                'deny'      => 'Deny',
                'inherit'   => 'Inherit',
            ],
            'delete'        => 'Delete',
            'edit'          => 'Edit',
            'read'          => 'Read',
            'toggle'        => 'Toggle',
        ],
        'allowed'           => 'Allowed',
        'fields'            => [
            'member'    => 'Member',
            'role'      => 'Role',
        ],
        'helper'            => 'Use this interface to fine-tune which users and roles that can interact with this entity. :allow',
        'helpers'           => [
            'setup' => 'Use this interface to fine-tune how roles and users can interact with this entity. :allow will allow the user or role to do this action. :deny will deny them that action. :inherit will use the user\'s role or main role\'s permission. A user set to :allow is able to do the action, even if their role is set to :deny.',
        ],
        'inherited'         => 'This role already has this permission set for this entity type.',
        'inherited_by'      => 'This user is part of the \':role\' role which grants this permissions on this entity type.',
        'success'           => 'Permissions saved.',
        'title'             => 'Permissions',
        'too_many_members'  => 'This campaign has too many members (>:number) to display in this interface. Please use the Permission button on the entity view to control permissions in detail.',
    ],
    'placeholders'              => [
        'ability'       => 'Choose an ability',
        'calendar'      => 'Choose a calendar',
        'character'     => 'Choose a character',
        'creature'      => 'Choose a creature',
        'entity'        => 'Choose an entity',
        'entry'         => 'Use @ followed by three letters to mention other entities of the campaign.',
        'event'         => 'Choose an event',
        'fallback'      => 'Choose :module',
        'family'        => 'Choose a family',
        'gallery_image' => 'Choose an image from the campaign gallery',
        'image_url'     => 'Upload an image from a URL instead',
        'item'          => 'Choose an object',
        'journal'       => 'Choose a journal',
        'location'      => 'Choose a location',
        'map'           => 'Choose a map',
        'multiple'      => 'Choose one or several',
        'name'          => 'Name of the entity',
        'note'          => 'Choose a note',
        'organisation'  => 'Choose an organisation',
        'parent'        => 'Choose a parent',
        'quest'         => 'Choose a quest',
        'race'          => 'Choose a race',
        'tag'           => 'Choose a tag',
        'timeline'      => 'Choose a timeline',
        'user'          => 'Choose a user',
    ],
    'remove'                    => 'Remove',
    'rename'                    => 'Rename',
    'reorder'                   => [
        'empty' => 'No elements to reorder.',
    ],
    'save'                      => 'Save',
    'save_and_close'            => 'Save and Close',
    'save_and_copy'             => 'Save and Copy',
    'save_and_new'              => 'Save and New',
    'save_and_update'           => 'Save and Edit',
    'save_and_view'             => 'Save and View',
    'search'                    => 'Search',
    'select'                    => 'Select',
    'superboosted_campaigns'    => 'Superboosted Campaigns',
    'tabs'                      => [
        'abilities'     => 'Abilities',
        'assets'        => 'Assets',
        'attributes'    => 'Attributes',
        'boost'         => 'Boost',
        'connections'   => 'Connections',
        'inventory'     => 'Inventory',
        'links'         => 'Links',
        'mentions'      => 'Mentions',
        'overview'      => 'Overview',
        'permissions'   => 'Permissions',
        'premium'       => 'Premium',
        'profile'       => 'Profile',
        'relations'     => 'Relations',
        'reminders'     => 'Reminders',
        'story'         => 'Overview',
    ],
    'titles'                    => [
        'editing'   => 'Editing :name',
        'new'       => 'New :module',
    ],
    'tooltips'                  => [
        'new_post'  => 'Add a new post to this entity.',
    ],
    'update'                    => 'Update',
    'users'                     => [
        'unknown'   => 'Unknown',
    ],
    'view'                      => 'View',
    'visibilities'              => [
        'admin'         => 'Admins',
        'admin-self'    => 'Only me & Admins',
        'all'           => 'All',
        'members'       => 'Members of the campaign',
        'self'          => 'Only me',
    ],
];
