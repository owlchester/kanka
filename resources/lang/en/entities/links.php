<?php

return [
    'actions'       => [
        'add'   => 'Add a link',
    ],
    'create'        => [
        'success'   => 'Link :name added to :entity.',
        'title'     => 'Add a link to :name',
    ],
    'destroy'       => [
        'success'   => 'Link :name removed.',
    ],
    'fields'        => [
        'icon'      => 'Icon',
        'name'      => 'Name',
        'position'  => 'Position',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'Go to :name',
        'icon'      => 'You can customise the icon displayed for the link. Use any of the free icons from :fontawesome or leave this field blank for the default.',
        'leaving'   => 'You are about to leave Kanka and go to another domain. The page you are leaving to was provided by a user and isn\'t vetted by our website.',
        'url'       => 'The url you are about to go to is :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Boosted campaigns can add links to entities that point to external websites.',
        'title'     => 'Links for :name',
    ],
    'unboosted'     => [
        'text'  => 'Adding links to external resources that are displayed directly on the entity is reserved to :boosted-campaigns.',
        'title' => 'Boosted campaign feature',
    ],
    'update'        => [
        'success'   => 'Link :name updated for :entity.',
        'title'     => 'Update link for :name',
    ],
];
