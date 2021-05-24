<?php

return [
    'actions'       => [
        'apply_template'    => 'Apply an Attribute Template',
        'manage'            => 'Manage',
        'more'              => 'More options',
        'remove_all'        => 'Delete All',
    ],
    'errors'        => [
        'loop'  => 'There is an endless loop in this attribute calculation!',
    ],
    'fields'        => [
        'attribute'             => 'Attribute',
        'community_templates'   => 'Community Templates',
        'is_private'            => 'Private Attributes',
        'is_star'               => 'Pinned',
        'template'              => 'Template',
        'value'                 => 'Value',
    ],
    'helpers'       => [
        'delete_all'    => 'Are you sure you want to delete all of this entity\'s attributes?',
    ],
    'hints'         => [
        'is_private'    => 'You can hide all the attributes of an entity for all members outside of the admin role by making it private.',
    ],
    'index'         => [
        'success'   => 'Attributes for :entity updated.',
        'title'     => 'Attributes for :name',
    ],
    'placeholders'  => [
        'attribute' => 'Number of conquests, Challenge Rating, Initiative, Population',
        'block'     => 'Block name',
        'checkbox'  => 'Checkbox name',
        'icon'      => [
            'class' => 'FontAwesome or RPG Awesome class: fas fa-users',
            'name'  => 'Icon name',
        ],
        'random'    => [
            'name'  => 'Attribute name',
            'value' => '1-100 or list of values separated by a comma',
        ],
        'section'   => 'Section name',
        'template'  => 'Select a template',
        'value'     => 'Value of the attribute',
    ],
    'show'          => [
        'title'     => ':name Attributes',
    ],
    'template'      => [
        'success'   => 'Attribute Template :name applied to :entity',
        'title'     => 'Apply an Attribute Template for :name',
    ],
    'types'         => [
        'attribute' => 'Attribute',
        'block'     => 'Block',
        'checkbox'  => 'Checkbox',
        'icon'      => 'Icon',
        'random'    => 'Random',
        'section'   => 'Section',
        'text'      => 'Multiline Text',
    ],
    'update'         => [
        'success'   => 'Attributes for :entity updated.',
    ],
    'visibility'    => [
        'entry'     => 'Attribute is displayed on the entity menu.',
        'private'   => 'Attribute only visible to members of the "Admin" role.',
        'public'    => 'Attribute visible to all members.',
        'tab'       => 'Attribute is displayed only on the Attributes tab.',
    ],
];
