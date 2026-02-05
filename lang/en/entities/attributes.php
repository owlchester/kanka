<?php

return [
    'actions'       => [
        'apply_template'    => 'Apply an attribute template',
        'load'              => 'Load',
        'manage'            => 'Manage',
        'more'              => 'Others',
        'remove_all'        => 'Delete all',
        'save_and_edit'     => 'Apply and Edit',
        'save_and_story'    => 'Apply and View',
        'show_hidden'       => 'Show hidden attributes',
        'toggle_privacy'    => 'Private/Public',
    ],
    'errors'        => [
        'api'                   => 'Invalid data',
        'loop'                  => 'There is an endless loop in this attribute calculation!',
        'no_attribute_selected' => 'Select one or more attributes first.',
        'too_many_v2'           => 'Max fields reached (:count/:max). Delete some attributes first before being able to add more.',
    ],
    'fields'        => [
        'attribute'             => 'Attribute',
        'community_templates'   => 'Community Templates',
        'is_private'            => 'Private Attributes',
        'is_star'               => 'Pinned',
        'preferences'           => 'Preferences',
        'template'              => 'Template',
        'value'                 => 'Value',
    ],
    'filters'       => [
        'name'  => 'Attribute name',
        'value' => 'Attribute value',
    ],
    'helpers'       => [
        'delete_all'    => 'Are you sure you want to delete all of this entity\'s attributes?',
        'is_private'    => 'Only allow members of the :admin-role role to see this entity\'s attributes.',
        'setup'         => 'You can represent elements like HP or intelligence of an entity with attributes. Add attributes manually by clicking on the :manage button, or apply those from an attribute template.',
    ],
    'index'         => [
        'success'   => 'Attributes for :entity updated.',
        'title'     => 'Attributes for :name',
    ],
    'labels'        => [
        'checkbox'  => 'Checkbox name',
        'name'      => 'Attribute name',
        'section'   => 'Section name',
        'value'     => 'Attribute value',
    ],
    'live'          => [
        'success'   => 'Attribute :attribute updated.',
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
            'name'  => 'Attribute name',
            'value' => '1-100 or list of values separated by a comma',
        ],
        'section'   => 'Section name',
        'template'  => 'Select a template',
        'value'     => 'Value of the attribute',
    ],
    'ranges'        => [
        'text'  => 'Available options: :options',
    ],
    'sections'      => [
        'unorganised'   => 'Unorganised',
    ],
    'show'          => [
        'hidden'    => 'Hidden Attributes',
        'title'     => ':name Attributes',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Template loaded',
            'title'     => 'Load from template',
        ],
        'pitch'     => 'Load attributes from an attribute template or plugins installed from the :plugin.',
        'success'   => 'Attribute template :name applied to :entity',
        'title'     => 'Apply an attribute template for :name',
    ],
    'title'         => 'Attributes',
    'toasts'        => [
        'bulk_deleted'  => 'Attributes deleted',
        'bulk_privacy'  => 'Attributes privacy toggled',
        'lock'          => 'Attribute locked',
        'pin'           => 'Attribute pinned',
        'unlock'        => 'Attribute unlocked',
        'unpin'         => 'Attribute unpinned',
    ],
    'types'         => [
        'attribute' => 'Text',
        'block'     => 'Block',
        'checkbox'  => 'Checkbox',
        'icon'      => 'Icon',
        'number'    => 'Number',
        'random'    => 'Random',
        'section'   => 'Section',
        'templates' => 'Templates',
        'text'      => 'Paragraph',
    ],
    'update'        => [
        'success'   => 'Attributes for :entity updated.',
    ],
    'visibility'    => [
        'entry'     => 'Attribute is displayed on the entity menu.',
        'private'   => 'Attribute only visible to members of the "Admin" role.',
        'public'    => 'Attribute visible to all members.',
        'tab'       => 'Attribute is displayed only on the Attributes tab.',
    ],
];
