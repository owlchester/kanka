<?php

return [
    'actions'       => [
        'apply_kit'     => 'Apply a property kit',
        'load'              => 'Load',
        'manage'            => 'Manage',
        'more'              => 'Others',
        'remove_all'        => 'Delete all',
        'save_and_edit'     => 'Apply and Edit',
        'save_and_story'    => 'Apply and View',
        'show_hidden'       => 'Show hidden properties',
        'toggle_privacy'    => 'Private/Public',
    ],
    'errors'        => [
        'api'                   => 'Invalid data',
        'loop'                  => 'There is an endless loop in this property calculation!',
        'no_attribute_selected' => 'Select one or more properties first.',
        'too_many_v2'           => 'Max fields reached (:count/:max). Delete some properties first before being able to add more.',
    ],
    'fields'        => [
        'community_templates'   => 'Community Templates',
        'is_private'            => 'Private properties',
        'is_star'               => 'Pinned',
        'preferences'           => 'Preferences',
        'property' => 'Property',
        'template'              => 'Template',
        'value'                 => 'Value',
    ],
    'filters'       => [
        'name'  => 'Property name',
        'value' => 'Property value',
    ],
    'helpers'       => [
        'delete_all'    => 'Are you sure you want to delete all of this entry\'s properties?',
        'is_private'    => 'Only allow members of the :admin-role role to see this entry\'s properties.',
        'setup'         => 'You can represent elements like HP or intelligence of an entry with properties. Add properties manually by clicking on the :manage button, or apply those from a property kit.',
    ],
    'index'         => [
        'success'   => 'Properties for :entity updated.',
        'title'     => 'Properties for :name',
    ],
    'labels'        => [
        'checkbox'  => 'Checkbox name',
        'name'      => 'Property name',
        'section'   => 'Section name',
        'value'     => 'Property value',
    ],
    'live'          => [
        'success'   => 'Property :attribute updated.',
        'title'     => 'Updating :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Number of conquests, Challenge Rating, Initiative, Population',
        'block'     => 'Multiline name',
        'checkbox'  => 'Checkbox name',
        'icon'      => [
            'class' => 'FontAwesome or RPG Awesome class: fas fa-users',
            'name'  => 'Icon name',
        ],
        'number'    => 'Number value',
        'random'    => [
            'name'  => 'Property name',
            'value' => '1-100 or list of values separated by a comma',
        ],
        'section'   => 'Section name',
        'template'  => 'Select a template',
        'value'     => 'Value of the properties',
    ],
    'ranges'        => [
        'text'  => 'Available options: :options',
    ],
    'sections'      => [
        'unorganised'   => 'Unorganised',
    ],
    'show'          => [
        'hidden'    => 'Hidden properties',
        'title'     => ':name properties',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Template loaded',
            'title'     => 'Load from kit',
        ],
        'pitch'     => 'Load properties from a property kit or plugins installed from the :plugin.',
        'success'   => 'Property kit :name applied to :entity',
        'title'     => 'Apply a property kit on :name',
    ],
    'title'         => 'Properties',
    'toasts'        => [
        'bulk_deleted'  => 'Property deleted',
        'bulk_privacy'  => 'Property privacy toggled',
        'lock'          => 'Property locked',
        'pin'           => 'Property pinned',
        'unlock'        => 'Property unlocked',
        'unpin'         => 'Property unpinned',
    ],
    'types'         => [
        'attribute' => 'Text',
        'block'     => 'Block',
        'checkbox'  => 'Checkbox',
        'icon'      => 'Icon',
        'number'    => 'Number',
        'random'    => 'Random',
        'section'   => 'Section',
        'kits' => 'Kits',
        'text'      => 'Paragraph',
    ],
    'update'        => [
        'success'   => 'Properties for :entity updated.',
    ],
    'visibility'    => [
        'entry'     => 'Property is displayed on the entry menu.',
        'private'   => 'Property only visible to members of the "Admin" role.',
        'public'    => 'Property visible to all members.',
        'tab'       => 'Property is displayed only on the Properties tab.',
    ],
];
