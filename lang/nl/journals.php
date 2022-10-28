<?php

return [
    'create'        => [
        'title' => 'Nieuw Logboek',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Auteur',
        'date'      => 'Datum',
        'journal'   => 'Bovenliggend Logboek',
        'journals'  => 'Sub Logboek',
    ],
    'helpers'       => [
        'journals'  => 'Geef alle of alleen de directe sub logboeken van dit logboek weer.',
    ],
    'index'         => [],
    'journals'      => [
        'title' => 'Logboek :name sub logboeken',
    ],
    'placeholders'  => [
        'author'    => 'Wie schreef het logboek',
        'date'      => 'Echte werelddatum van het logboek',
        'journal'   => 'Kies een bovenliggend logboek',
        'name'      => 'Naam van het logboek',
        'type'      => 'Sessie, One Shot, Concept',
    ],
    'show'          => [
        'tabs'  => [
            'journals'  => 'Logboeken',
        ],
    ],
];
