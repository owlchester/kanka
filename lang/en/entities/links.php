<?php

return [
    'actions'           => [
        'add'   => 'Add a link',
    ],
    'call-to-action'    => 'Add links to external resources on this entity, like to DnDBeyond, and they will display directly on the entity\'s overview.',
    'create'            => [
        'helper'    => 'Add an external link to :name, for example to their DnDBeyond page.',
        'success'   => 'Link :name added to :entity.',
        'title'     => 'New link',
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
    'go'                => [
        'actions'       => [
            'confirm'   => 'I\'m sure',
            'trust'     => 'Don\'t ask me again',
        ],
        'description'   => 'This link will take you to :link. Are you sure you want to go there?',
        'title'         => 'Leaving Kanka',
    ],
    'helpers'           => [
        'icon'      => 'Customise the link icon with one from :fontawesome or :rpgawesome. Find our more about available icons in our :docs.',
        'parent'    => 'Display this bookmark after an element of the sidebar, rather than in the bookmark section of the sidebar.',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Premium campaigns can add links to entities that point to external websites.',
        'title'     => 'Links for :name',
    ],
    'update'            => [
        'success'   => 'Link :name updated for :entity.',
        'title'     => 'Update link for :name',
    ],
];
