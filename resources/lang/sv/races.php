<?php

return [
    'characters'    => [
        'description'   => 'Karaktärer som tillhör rasen.',
        'helpers'       => [
            'all_characters'    => 'Visar alla karaktärer tillhörande denna ras eller dess underraser.',
            'characters'        => 'Visar alla karaktärer som direkt tillhör denna ras.',
        ],
        'title'         => 'Ras :name Karaktärer',
    ],
    'create'        => [
        'description'   => 'Skapa en ny ras',
        'success'       => 'Ras \':name\' skapad.',
        'title'         => 'Ny Ras',
    ],
    'destroy'       => [
        'success'   => 'Ras \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Ras \':name\' uppdaterad.',
        'title'     => 'Redigera Ras :name',
    ],
    'fields'        => [
        'characters'    => 'Karaktärer',
        'name'          => 'Namn',
        'race'          => 'Huvudras',
        'races'         => 'Underras',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'I Hierarkisk Vy kan du se dina raser i hierarkisk ordning. Raser utan en huvudras kommer visas som standard. Raser med underraser kan klickas på för att visa dessa. Du kan fortsätta klicka tills det inte finns fler underraser.',
    ],
    'index'         => [
        'add'           => 'Ny Ras',
        'description'   => 'Hantera raser av :name.',
        'header'        => 'Raser av :name',
        'title'         => 'Raser',
    ],
    'placeholders'  => [
        'name'  => 'Namn på rasen',
        'type'  => 'Människa, Väsen, Borg',
    ],
    'races'         => [
        'description'   => 'Raser som tillhör rasen.',
        'title'         => 'Ras :name Underraser',
    ],
    'show'          => [
        'description'   => 'En detaljerad vy för en ras',
        'tabs'          => [
            'characters'    => 'Karaktärer',
            'menu'          => 'Meny',
            'races'         => 'Underraser',
        ],
        'title'         => 'Ras :name',
    ],
];
