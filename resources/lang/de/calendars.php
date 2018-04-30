<?php

return [
    'actions'   => [
        'add_month'     => 'Monat hinzufügen',
        'add_weekday'   => 'Wochentag hinzufügen',
        'add_year'      => 'Jahr hinzufügen',
    ],
    'create'    => [
        'description'   => 'Einen neuen Kalender erstellen',
        'success'       => 'Kalender \':name\' erstellt.',
        'title'         => 'Neuer Kalender',
    ],
    'destroy'   => [
        'success'   => 'Kalender \':name\' gelöscht',
    ],
    'edit'      => [
        'success'   => 'Kalender \':name\' aktualisiert',
        'title'     => 'Kalender :name bearbeiten',
    ],
    'event'     => [
        'destroy'   => 'Ereignis aus Kalender :name entfernt',
        'helpers'   => [
            'add'   => 'Füge ein bestehendes Ereignis aus der Liste hinzu.',
        ],
    ],
];
