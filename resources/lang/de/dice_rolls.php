<?php

return [
    'create'        => [
        'success'       => 'Würfelwurf \':name\' erstellt.',
        'title'         => 'Neuer Würfelwurf',
    ],
    'destroy'       => [
        'dice_roll' => 'Würfelwurf entfernt.',
        'success'   => 'Würfelwurf \':name\' entfernt.',
    ],
    'edit'          => [
        'success'       => 'Würfelwurf \':name\' aktualisiert.',
        'title'         => 'Bearbeite Würfelwurf \':name\'',
    ],
    'fields'        => [
        'created_at'    => 'Gewürfelt am',
        'name'          => 'Name',
        'parameters'    => 'Parameter',
        'results'       => 'Ergebnisse',
        'rolls'         => 'Würfe',
    ],
    'hints'         => [
        'parameters'    => 'Was sind meine Würfeloptionen?',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'Würfelwürfe',
            'results'   => 'Ergebnisse',
        ],
        'add'           => 'Neuer Würfelwurf',
        'header'        => 'Würfelwürfe von :name',
        'title'         => 'Würfelwürfe',
    ],
    'placeholders'  => [
        'dice_roll' => 'Würfelwurf',
        'name'      => 'Name des Würfelwurfs',
        'parameters'=> '4d6+3',
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
        'tabs'          => [
            'results'   => 'Ergebnisse',
        ],
        'title'         => 'Würfelwurf :name',
    ],
];
