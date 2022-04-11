<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Lägg till en ny tagg',
        ],
        'create'    => [
            'title' => 'Lägg till en tagg på :name',
        ],
        'title'     => 'Tagg :name undertaggar',
    ],
    'create'        => [
        'success'   => 'Tagg \':name\' skapad.',
        'title'     => 'Ny Tagg',
    ],
    'destroy'       => [
        'success'   => 'Tagg \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Tagg \':name\' uppdaterad.',
        'title'     => 'Redigera Tagg :name',
    ],
    'fields'        => [
        'children'  => 'Undertaggar',
        'name'      => 'Namn',
        'tag'       => 'Huvudtagg',
        'tags'      => 'Undertaggar',
        'type'      => 'Typ',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Denna lista innehåller alla entiteter som har denna tag eller någon av dess undertaggar.',
        'tag'       => 'Visad nedan är alla taggar direkt under denna tagg.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Hierarkisk Vy',
        ],
        'add'       => 'Ny Tagg',
        'header'    => 'Taggar i :name',
        'title'     => 'Taggar',
    ],
    'new_tag'       => 'Ny Tagg',
    'placeholders'  => [
        'name'  => 'Namn på taggen',
        'tag'   => 'Välj en huvudtagg',
        'type'  => 'Kunskap, Krig, Historia, Religion, Vexillologi',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Undertaggar',
            'tags'      => 'Taggar',
        ],
        'title' => 'Tagg :name',
    ],
    'tags'          => [
        'title' => 'Tag :name undertaggar',
    ],
];
