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
        'title' => 'Ny Tagg',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Undertaggar',
        'tag'       => 'Huvudtagg',
        'tags'      => 'Undertaggar',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Denna lista innehåller alla entiteter som har denna tag eller någon av dess undertaggar.',
        'tag'       => 'Visad nedan är alla taggar direkt under denna tagg.',
    ],
    'index'         => [],
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
    ],
    'tags'          => [
        'title' => 'Tag :name undertaggar',
    ],
];
