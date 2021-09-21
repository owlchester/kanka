<?php

return [
    'characters'    => [
        'description'   => 'Charaktere, die der Spezies angehören.',
        'helpers'       => [
            'all_characters'    => 'Anzeige aller Charaktere, die sich auf diese Spezies und seine Unterspezies beziehen.',
            'characters'        => 'Anzeige aller Charaktere, die in direktem Zusammenhang mit dieser Spezies stehen.',
        ],
        'title'         => 'Spezies :name Charaktere',
    ],
    'create'        => [
        'description'   => 'Erstelle eine neue Spezies',
        'success'       => 'Spezies \':name\' erstellt.',
        'title'         => 'Neue Spezies',
    ],
    'destroy'       => [
        'success'   => 'Spezies \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Spezies \':name\' aktualisiert.',
        'title'     => 'Bearbeite Spezies :name',
    ],
    'fields'        => [
        'characters'    => 'Charaktere',
        'name'          => 'Name',
        'race'          => 'Übergeordnete Spezies',
        'races'         => 'Unterspezies',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested_parent' => 'Anzeigen der Spezies von :parent.',
        'nested_without'=> 'Anzeige aller Spezies, die keine übergeordnete Spezies haben. Klicken Sie auf eine Zeile, um die untergeordneten Spezies anzuzeigen.',
    ],
    'index'         => [
        'add'           => 'Neue Spezies',
        'description'   => 'Verwalte die Spezies von :name.',
        'header'        => 'Spezies von :name',
        'title'         => 'Spezies',
    ],
    'placeholders'  => [
        'name'  => 'Name der Spezies',
        'type'  => 'Mensch, Fee, Borg',
    ],
    'races'         => [
        'description'   => 'Spezies, die zu dieser Spezies gehören.',
        'title'         => 'Spezies :name Unterspezies',
    ],
    'show'          => [
        'description'   => 'Eine Detailansicht einer Spezies',
        'tabs'          => [
            'characters'    => 'Charaktere',
            'menu'          => 'Menü',
            'races'         => 'Unterspezies',
        ],
        'title'         => 'Spezies :name',
    ],
];
