<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'attach'    => 'An Objekt anhängen',
        ],
        'create'        => [
            'attach_success'    => '{1} Die Fähigkeit :name wurde an :count Objekt angehängt.|[2,*] Die Fähigkeit :name wurde an :count Objekte angehängt.',
            'helper'            => 'Anhängen von :name an ein oder mehrere Objekten.',
            'title'             => 'Objekte anhängen',
        ],
        'description'   => 'Objekte mit dieser Fähigkeit',
        'title'         => 'Fähigkeit :name Objekt',
    ],
    'create'        => [
        'title' => 'Neue Fähigkeit',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Ladungen',
    ],
    'helpers'       => [],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Anzahl der Verwendungen. Attribute können mit mit {Level} * {CHA} referenziert werden.',
        'name'      => 'Feuerball, Alarm, listiger Schlag',
        'type'      => 'Zauber, Kraftakt, Attacke',
    ],
    'reorder'       => [
        'parentless'    => 'kein übergepordnetes Objekt',
        'success'       => 'Fähigkeiten erfolgreich neu geordnet.',
        'title'         => 'Ordne die Fähigkeiten neu',
    ],
    'show'          => [
        'tabs'  => [
            'reorder'   => 'Fähigkeiten neu anordnen',
        ],
    ],
];
