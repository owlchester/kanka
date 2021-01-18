<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Lägg till en ny tagg',
        ],
        'create'        => [
            'title' => 'Lägg till en tagg på :name',
        ],
        'description'   => 'Entiteter tillhörande taggen',
        'title'         => 'Tagg :name undertaggar',
    ],
    'create'        => [
        'description'   => 'Skapa en ny tagg',
        'success'       => 'Tagg \':name\' skapad.',
        'title'         => 'Ny Tagg',
    ],
    'destroy'       => [
        'success'   => 'Tagg \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Tagg \':name\' uppdaterad.',
        'title'     => 'Redigera Tagg :name',
    ],
    'fields'        => [
        'characters'    => 'Karaktärer',
        'children'      => 'Undertaggar',
        'name'          => 'Namn',
        'tag'           => 'Huvudtagg',
        'tags'          => 'Undertaggar',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'I Hierarkisk Vy kan du se dina taggar i hierarkisk ordning. Taggar utan en huvudtagg kommer visas som standard. Taggar med undertaggar kan klickas på för att visa dessa. Du kan fortsätta klicka tills det inte finns fler undertaggar.',
    ],
    'hints'         => [
        'children'  => 'Denna lista innehåller alla entiteter som har denna tag eller någon av dess undertaggar.',
        'tag'       => 'Visad nedan är alla taggar direkt under denna tagg.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Hierarkisk Vy',
        ],
        'add'           => 'Ny Tagg',
        'description'   => 'Hantera Taggen för :name',
        'header'        => 'Taggar i :name',
        'title'         => 'Taggar',
    ],
    'new_tag'       => 'Ny Tagg',
    'placeholders'  => [
        'name'  => 'Namn på taggen',
        'tag'   => 'Välj en huvudtagg',
        'type'  => 'Kunskap, Krig, Historia, Religion, Vexillologi',
    ],
    'show'          => [
        'description'   => 'En detaljerad vy för en tagg',
        'tabs'          => [
            'children'      => 'Undertaggar',
            'information'   => 'Information',
            'tags'          => 'Taggar',
        ],
        'title'         => 'Tagg :name',
    ],
    'tags'          => [
        'description'   => 'Undertaggar',
        'title'         => 'Tag :name undertaggar',
    ],
];
