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
    ],
    'helpers'       => [
        'journals'  => 'Geef alle of alleen de directe sub logboeken van dit logboek weer.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Wie schreef het logboek',
        'date'      => 'Echte werelddatum van het logboek',
        'type'      => 'Sessie, One Shot, Concept',
    ],
    'show'          => [],
];
