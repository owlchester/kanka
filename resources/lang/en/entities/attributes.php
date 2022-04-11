<?php

return [
    'actions'       => [
        'apply_template'    => 'Apply an attribute template',
        'manage'            => 'Manage',
        'more'              => 'More options',
        'remove_all'        => 'Delete All',
    ],
    'errors'        => [
        'loop'      => 'There is an endless loop in this attribute calculation!',
        'too_many'  => 'There are too many fields on this entity, can\'t add more attributes. Delete some attributes first before being able to add more.',
    ],
    'fields'        => [
        'attribute'             => 'Attribute',
        'community_templates'   => 'Community Templates',
        'is_private'            => 'Private Attributes',
        'is_star'               => 'Pinned',
        'template'              => 'Template',
        'value'                 => 'Value',
    ],
    'filters'       => [
        'name'  => 'Attribute name',
        'value' => 'Attribute value',
    ],
    'helpers'       => [
        'delete_all'    => 'Are you sure you want to delete all of this entity\'s attributes?',
        'setup'         => 'You can represent elements like HP or intelligence of an entity with attributes. Add attributes manually by clicking on the :manage button, or apply those from an attribute template.',
    ],
    'hints'         => [
        'is_private2'   => 'If selected, only members of the :admin-role role can see the attributes of this entity.',
    ],
    'index'         => [
        'success'   => 'Attributes for :entity updated.',
        'title'     => 'Attributes for :name',
    ],
    'live'          => [
        'success'   => 'Attribute :attribute updated.',
        'title'     => 'Updating :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Number of conquests, Challenge Rating, Initiative, Population',
        'block'     => 'Block name',
        'checkbox'  => 'Checkbox name',
        'icon'      => [
            'class' => 'FontAwesome or RPG Awesome class: fas fa-users',
            'name'  => 'Icon name',
        ],
        'number'    => 'Number name',
        'random'    => [
            'name'  => 'Attribute name',
            'value' => '1-100 or list of values separated by a comma',
        ],
        'section'   => 'Section name',
        'template'  => 'Select a template',
        'value'     => 'Value of the attribute',
    ],
    'show'          => [
        'title' => ':name Attributes',
    ],
    'template'      => [
        'success'   => 'Attribute template :name applied to :entity',
        'title'     => 'Apply an attribute template for :name',
    ],
    'types'         => [
        'attribute' => 'Attribute',
        'block'     => 'Block',
        'checkbox'  => 'Checkbox',
        'icon'      => 'Icon',
        'number'    => 'Number',
        'random'    => 'Random',
        'section'   => 'Section',
        'text'      => 'Multiline Text',
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
