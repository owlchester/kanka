<?php

return [
    'create'        => [
        'description'   => 'Crea una nova tirada de daus',
        'success'       => 'S\'ha creat la tirada de daus «:name».',
        'title'         => 'Nova tirada de daus',
    ],
    'destroy'       => [
        'dice_roll' => 'S\'ha eliminat la tirada de daus.',
        'success'   => 'S\'ha eliminat la tirada de daus «:name».',
    ],
    'edit'          => [
        'description'   => 'Edita la tirada de daus',
        'success'       => 'S\'ha actualitzat la tirada de daus «:name».',
        'title'         => 'Edita la tirada de daus :name',
    ],
    'fields'        => [
        'created_at'    => 'Tirada a',
        'name'          => 'Nom',
        'parameters'    => 'Paràmetres',
        'results'       => 'Resultats',
        'rolls'         => 'Tirades',
    ],
    'hints'         => [
        'parameters'    => 'Quines són les opcions per tirar daus?',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'Tirades de daus',
            'results'   => 'Resultats',
        ],
        'add'           => 'Nova tirada de daus',
        'description'   => 'Gestiona les tirades de daus de :name.',
        'header'        => 'Tirada de daus de :name',
        'title'         => 'Tirades de daus',
    ],
    'placeholders'  => [
        'dice_roll' => 'Tirada de daus',
        'name'      => 'Nom de la tirada de daus',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Tirada',
        ],
        'error'     => 'La tirada de daus ha fallat. No es poden analitzar els paràmetres.',
        'fields'    => [
            'creator'   => 'Creador',
            'date'      => 'Data',
            'result'    => 'Resultat',
        ],
        'hint'      => 'S\'han completat totes les tirades de la plantilla.',
        'success'   => 'S\'han llençat els daus.',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la tirada de daus',
        'tabs'          => [
            'results'   => 'Resultats',
        ],
        'title'         => 'Tirada de daus :name',
    ],
];
