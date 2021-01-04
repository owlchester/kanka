<?php

return [
    'actions'   => [
        'add'   => 'Add a link',
    ],
    'create'    => [
        'success'           => 'Link :name added to :entity.',
        'title'             => 'Add a link to :name',
    ],
    'update'    => [
        'success'           => 'Link :name updated for :entity.',
        'title'             => 'Update link for :name',
    ],
    'fields' => [
        'name' => 'Name',
        'icon' => 'Icon',
        'position' => 'Position',
        'url' => 'Url',
    ],
    'placeholders' => [
        'name' => 'DNDBeyond',
        'url' => 'https://dndbeyond.com/character-url',
        'icon' => 'fab fa-d-and-d-beyond'
    ],
    'helpers' => [
        'leaving' => 'You are about to leave Kanka and go to another domain. The page you are leaving to was provided by a user and isn\'t vetted by our website.',
        'goto' => 'Go to :name',
        'url' => 'The url you are about to go to is :url.',
        'icon' => 'You can customise the icon displayed for the link. Use any of the free icons from :fontawesome or leave this field blank for the default.',
    ],
    'show'      => [
        'helper'    => 'Boosted campaigns can add links to entities that point to external websites.',
        'title'     => 'Links for :name',
    ],
];
