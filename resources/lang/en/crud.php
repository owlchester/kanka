<?php

return [
    'actions'       => [
        'back'  => 'Back',
        'copy'  => 'Copy',
        'move'  => 'Move',
        'new'   => 'New',
    ],
    'add'           => 'Add',
    'attributes'    => [
        'actions'       => [
            'add'               => 'Add an attribute',
            'apply_template'    => 'Apply an Attribute Template',
            'manage'            => 'Manage',
        ],
        'create'        => [
            'description'   => 'Create a new attribute',
            'success'       => 'Attribute :name added to :entity.',
            'title'         => 'New Attribute for :name',
        ],
        'destroy'       => [
            'success'   => 'Attribute :name for :entity removed.',
        ],
        'edit'          => [
            'description'   => 'Update an existing attribute',
            'success'       => 'Attribute :name for :entity updated.',
            'title'         => 'Update attribute for :name',
        ],
        'fields'        => [
            'attribute' => 'Attribute',
            'template'  => 'Template',
            'value'     => 'Value',
        ],
        'index'         => [
            'success'   => 'Attributes for :entity updated.',
            'title'     => 'Attributes for :name',
        ],
        'placeholders'  => [
            'attribute' => 'Number of conquests, Challenge Rating, Initiative, Population',
            'template'  => 'Select a template',
            'value'     => 'Value of the attribute',
        ],
        'template'      => [
            'success'   => 'Attribute Template :name applies on :entity',
            'title'     => 'Apply an Attribute Template for :name',
        ],
    ],
    'cancel'        => 'Cancel',
    'clear_filters' => 'Clear Filters',
    'click_modal'   => [
        'close'     => 'Close',
        'confirm'   => 'Confirm',
        'title'     => 'Confirm your action',
    ],
    'create'        => 'Create',
    'delete_modal'  => [
        'close'         => 'Close',
        'delete'        => 'Delete',
        'description'   => 'Are you sure you want to remove :tag?',
        'title'         => 'Delete confirmation',
    ],
    'destroy_many'  => [
        'success'   => 'Deleted :count entity|Deleted :count entities.',
    ],
    'edit'          => 'Edit',
    'fields'        => [
        'character'     => 'Character',
        'description'   => 'Description',
        'entity'        => 'Entity',
        'entry'         => 'Entry',
        'event'         => 'Event',
        'family'        => 'Family',
        'history'       => 'History',
        'image'         => 'Image',
        'organisation'  => 'Organisation',
        'is_private'    => 'Private',
        'location'      => 'Location',
    ],
    'filter'        => 'Filter',
    'filters'       => 'Filters',
    'hidden'        => 'Hidden',
    'hints'         => [
        'is_private'    => 'Hide from non "Admin" users.',
    ],
    'image'         => [
        'error' => 'We weren\'t able to get the image you requested. It could be that the website doesn\'t allow us to download the image (typically for Squarespace and DeviantArt), or that the link is no longer valid.',
    ],
    'is_private'    => 'This entity is private and not visible by non-admin users.',
    'linking_help'  => 'How can I link to other entries?',
    'manage'        => 'Manage',
    'move'          => [
        'description'   => 'Move this entity to another place',
        'fields'        => [
            'target'    => 'New type',
            'campaign' => 'New campaign',
        ],
        'hints'         => [
            'target'    => 'Please be aware that some data might be lost when moving an element from one type to another.',
            'campaign' => 'You can also try to move this entity to another campaign.',
        ],
        'success'       => 'Entity \':name\' moved.',
        'title'         => 'Move :name',
        'errors' => [
            'permission' => 'You aren\'t allowed to create entities of that type in the target campaign.',
            'same_campaign' => 'You need to select another campaign to move the entity to.',
            'unknown_campaign' => 'Unknown campaign.'
        ]
    ],
    'new_entity'    => [
        'error' => 'Please review your values.',
        'fields'=> [
            'name'  => 'Name',
        ],
        'title' => 'New entity',
    ],
    'or_cancel'     => 'or <a href=":url">cancel</a>',
    'panels'        => [
        'appearance'            => 'Appearance',
        'description'           => 'Description',
        'general_information'   => 'General Information',
        'history'               => 'History',
        'move'                  => 'Move',
    ],
    'permissions'   => [
        'action'    => 'Action',
        'actions'   => [
            'delete'    => 'Delete',
            'edit'      => 'Edit',
            'read'      => 'Read',
        ],
        'allowed'   => 'Allowed',
        'fields'    => [
            'member'    => 'Member',
            'role'      => 'Role',
        ],
        'helper'    => 'Use this interface to fine-tune which users and roles that can interact with this entity.',
        'success'   => 'Permissions saved.',
        'title'     => 'Permissions',
    ],
    'placeholders'  => [
        'character' => 'Choose a character',
        'event'     => 'Choose an event',
        'family'    => 'Choose a family',
        'image_url' => 'You can upload an image from a URL instead',
        'location'  => 'Choose a location',
        'organisation'  => 'Choose an organisation',
    ],
    'relations'     => [
        'actions'   => [
            'add'   => 'Add a relation',
        ],
        'fields'    => [
            'location'  => 'Location',
            'name'      => 'Name',
            'relation'  => 'Relation',
        ],
    ],
    'remove'        => 'Remove',
    'save'          => 'Save',
    'save_and_new'  => 'Save and New',
    'search'        => 'Search',
    'select'        => 'Select',
    'tabs'          => [
        'attributes'    => 'Attributes',
        'permissions'   => 'Permissions',
        'relations'     => 'Relations',
    ],
    'update'        => 'Update',
    'view'          => 'View',
];
