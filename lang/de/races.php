<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Anzeige aller Charaktere, die sich auf diese Spezies und seine Unterspezies beziehen.',
            'characters'        => 'Anzeige aller Charaktere, die in direktem Zusammenhang mit dieser Spezies stehen.',
        ],
        'title'     => 'Spezies :name Charaktere',
    ],
    'create'        => [
        'title' => 'Neue Spezies',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Charaktere',
        'locations'     => 'Standorte',
        'race'          => 'Übergeordnete Spezies',
        'races'         => 'Unterspezies',
    ],
    'helpers'       => [
        'nested_without'    => 'Anzeige aller Spezies, die keine übergeordnete Spezies haben. Klicken Sie auf eine Zeile, um die untergeordneten Spezies anzuzeigen.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Name der Spezies',
        'type'  => 'Mensch, Fee, Borg',
    ],
    'races'         => [
        'title' => 'Spezies :name Unterspezies',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Charaktere',
            'races'         => 'Unterspezies',
        ],
    ],
];
