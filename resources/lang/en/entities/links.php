<?php

return [
    'actions'           => [
        'add'   => 'Add a link',
    ],
    'call-to-action'    => 'Add links to external resources on this entity, like to DnDBeyond, and they will display directly on the entity\'s overview.',
    'create'            => [
        'success'   => 'Link :name added to :entity.',
        'title'     => 'Add a link to :name',
    ],
    'destroy'           => [
        'success'   => 'Link :name removed.',
    ],
    'fields'            => [
        'icon'      => 'Icon',
        'name'      => 'Name',
        'position'  => 'Position',
        'url'       => 'URL',
    ],
    'helpers'           => [
        'icon'      => 'You can customise the icon displayed for the link. Use any of the free icons from :fontawesome or leave this field blank for the default.',
    ],
    'go' => [
        'title' => 'Leaving Kanka',
        'description' => 'This link will take you to :link. Are you sure you want to go there?',
        'actions' => [
            'confirm' => 'I\'m sure',
            'trust' => 'Don\'t ask me again',
        ],
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Boosted campaigns can add links to entities that point to external websites.',
        'title'     => 'Links for :name',
    ],
    'update'            => [
        'success'   => 'Link :name updated for :entity.',
        'title'     => 'Update link for :name',
    ],
];
