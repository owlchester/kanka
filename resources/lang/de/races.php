<?php

return [
    'characters'    => [
        'description'   => 'Charakter, die der Rasse angehören.',
        'title'         => 'Rasse :name Charaktere',
    ],
    'create'        => [
        'description'   => 'Erstelle eine neue Rasse',
        'success'       => 'Rasse \':name\' erstellt.',
        'title'         => 'Neue Rasse',
    ],
    'destroy'       => [
        'success'   => 'Rasse \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Rasse \':name\' aktualisiert.',
        'title'     => 'Bearbeite Rasse :name',
    ],
    'fields'        => [
        'characters'    => 'Charaktere',
        'name'          => 'Name',
        'race'          => 'Übergeordnete Rasse',
        'races'         => 'Unterrassen',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'In der verschachtelten Ansicht, siehst du alle Rassen verschachtelt. Rassen ohne Oberrasse werden im Standard angezeigt. Rassen mit Unterrassen, können per Klick geöffnet werden, um die Unterrassen zu sehen. Das geht so tief, bis es keine Unterrasse mehr gibt.',
    ],
    'index'         => [
        'add'           => 'Neue Rasse',
        'description'   => 'Verwalte die Rassen von :name.',
        'header'        => 'Rassen von :name',
        'title'         => 'Rassen',
    ],
    'placeholders'  => [
        'name'  => 'Name der Rasse',
        'type'  => 'Mensch, Fey, Borg',
    ],
    'races'         => [
        'description'   => 'Rassen, die zu dieser Rasse gehören.',
        'title'         => 'Rasse :name Unterrassen',
    ],
    'show'          => [
        'description'   => 'Eine Detailansicht der Rasse',
        'tabs'          => [
            'characters'    => 'Charaktere',
            'menu'          => 'Menü',
            'races'         => 'Unterrasse',
        ],
        'title'         => 'Rasse :name',
    ],
];
