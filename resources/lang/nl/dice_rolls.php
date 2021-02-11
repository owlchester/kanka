<?php

return [
    'create'        => [
        'description'   => 'Maak een nieuwe dobbelsteen worp',
        'success'       => 'Dobbelsteen Worp \':name\' gemaakt.',
        'title'         => 'Nieuwe Dobbelsteen Worp',
    ],
    'destroy'       => [
        'dice_roll' => 'Dobbelsteen worp verwijderd.',
        'success'   => 'Dobbelsteen Worp \':name\' verwijderd.',
    ],
    'edit'          => [
        'description'   => 'Wijzig een dobbelsteen Worp',
        'success'       => 'Dobbelsteen Worp \':name\' bijgewerkt.',
        'title'         => 'Wijzig Dobbelsteen Worp :name',
    ],
    'fields'        => [
        'created_at'    => 'Gerold Bij',
        'name'          => 'Naam',
        'parameters'    => 'Parameters',
        'results'       => 'Resultaten',
        'rolls'         => 'Worpen',
    ],
    'hints'         => [
        'parameters'    => 'Wat zijn mijn dobbelsteen opties?',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'Dobbelsteen Worpen',
            'results'   => 'Resultaten',
        ],
        'add'           => 'Nieuwe Dobbelsteen Worp',
        'description'   => 'Beheer de dobbelsteen worpen van :name',
        'header'        => 'Dobbelsteen Worpen van :name',
        'title'         => 'Dobbelsteen Worpen van :name',
    ],
    'placeholders'  => [
        'dice_roll' => 'Dobbelsteen Worp',
        'name'      => 'Naam van de Dobbelsteen Worp',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Worp',
        ],
        'error'     => 'Dobbelsteen worp mislukt. Kan de parameters niet parseren.',
        'fields'    => [
            'creator'   => 'Maker',
            'date'      => 'Datum',
            'result'    => 'Resultaat',
        ],
        'hint'      => 'Alle worpen gedaan voor deze dobbelsteen worp sjabloon.',
        'success'   => 'Dobbelstenen gegooid.',
    ],
    'show'          => [
        'description'   => 'Een gedetailleerd overzicht van een Dobbelsteen Worp',
        'tabs'          => [
            'results'   => 'Resultaten',
        ],
        'title'         => 'Dobbelsteen Worp :name',
    ],
];
