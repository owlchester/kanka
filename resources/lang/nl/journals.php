<?php

return [
    'create'        => [
        'success'       => 'Logboek \':name\' gemaakt.',
        'title'         => 'Nieuw Logboek',
    ],
    'destroy'       => [
        'success'   => 'Logboek \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Logboek \':name\' bijgewerkt.',
        'title'     => 'Wijzig Logboek :name',
    ],
    'fields'        => [
        'author'    => 'Auteur',
        'date'      => 'Datum',
        'image'     => 'Afbeelding',
        'journal'   => 'Bovenliggend Logboek',
        'journals'  => 'Sub Logboek',
        'name'      => 'Naam',
        'relation'  => 'Relatie',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'journals'  => 'Geef alle of alleen de directe sub logboeken van dit logboek weer.',
        'nested'    => 'Eerst logboeken zonder bovenliggend logboek weergeven. Klik op een rij om de sub logboeken van het logboek te bekijken.',
    ],
    'index'         => [
        'add'           => 'Nieuw Logboek',
        'header'        => 'Logboeken van :name',
        'title'         => 'Logboeken',
    ],
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
        'tabs'          => [
            'journals'  => 'Logboeken',
        ],
        'title'         => 'Logboek :name',
    ],
];
