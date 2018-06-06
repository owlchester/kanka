<?php

return [
    'create'        => [
        'description'   => 'Erstelle einen neuen Würfelwurf',
        'success'       => 'Würfelwurf \':name\' erstellt.',
        'title'         => 'Neuer Würfelwurf',
    ],
    'destroy'       => [
        'dice_roll' => 'Würfelwurf entfernt.',
        'success'   => 'Würfelwurf \':name\' entfernt.',
    ],
    'edit'          => [
        'description'   => 'Bearbeite einen Würfelwurf',
        'success'       => 'Würfelwurf \':name\' aktualisiert.',
        'title'         => 'Bearbeite Würfelwurf \':name\'',
    ],
    'fields'        => [
        'name'          => 'Name',
        'parameters'    => 'Parameter',
        'results'       => 'Ergebnisse',
    ],
    'hints'         => [
        'parameters'    => 'Was sind meine Würfeloptionen?',
    ],
    'index'         => [
        'add'           => 'Neuer Würfelwurf',
        'description'   => 'Verwalte die Würfelwürfe von :name',
        'header'        => 'Würfelwürfe von :name',
        'title'         => 'Würfelwürfe',
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
        'description'   => 'Eine detaillierte Ansicht eines Würfelwurfs',
        'tabs'          => [
            'results'   => 'Ergebnisse',
        ],
        'title'         => 'Würfelwurf :name',
    ],
];
