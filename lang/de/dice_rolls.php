<?php

return [
    'create'        => [
        'title' => 'Neuer Würfelwurf',
    ],
    'destroy'       => [
        'dice_roll' => 'Würfelwurf entfernt.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Gewürfelt am',
        'parameters'    => 'Parameter',
        'results'       => 'Ergebnisse',
        'rolls'         => 'Würfe',
    ],
    'hints'         => [
        'parameters'    => 'Was sind meine Würfeloptionen?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Ergebnisse',
        ],
    ],
    'lists'         => [
        'empty' => 'Erstelle und speicher Würfelwürfe für die Kampagne, um die Ergebnisse direkt in Kanka zu verfolgen.',
    ],
    'placeholders'  => [
        'name'          => 'Name des Würfelwurfs',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Wurf',
        ],
        'error'     => 'Würfelwurf nicht erfolgreich. Kann die Parameter nicht parsen.',
        'fields'    => [
            'creator'   => 'Ersteller',
            'date'      => 'Datum',
            'result'    => 'Ergebnis',
        ],
        'hint'      => 'Alle Würfe, die für dieses Würfelwurf-Template gewürfelt wurden.',
        'success'   => 'Würfel gewürfelt.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Ergebnisse',
        ],
    ],
];
