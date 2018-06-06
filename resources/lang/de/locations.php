<?php

return [
    'create'        => [
        'description'   => 'Erstelle einen neuen Ort',
        'success'       => 'Ort \':name\' erstellt.',
        'title'         => 'Erstelle einen neuen Ort',
    ],
    'destroy'       => [
        'success'   => 'Ort \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Ort \':name\' aktualisiert.',
        'title'     => 'Bearbeite Ort :name',
    ],
    'fields'        => [
        'characters'    => 'Charaktere',
        'image'         => 'Bild',
        'location'      => 'Ort',
        'locations'     => 'Orte',
        'map'           => 'Karte',
        'name'          => 'Name',
        'relation'      => 'Beziehung',
        'type'          => 'Typ',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Erkundungsansicht',
        ],
        'add'           => 'Neuer Ort',
        'description'   => 'Verwalte den Ort von :name',
        'header'        => 'Orte in :name',
        'title'         => 'Orte',
    ],
    'map'           => [
        'actions'   => [
            'download'      => 'Herunterladen',
            'points'        => 'Punkte bearbeiten',
            'toggle_hide'   => 'Punkte verstecken',
            'toggle_show'   => 'Punkte anzeigen',
            'zoom_in'       => 'Hereinzoomen',
            'zoom_out'      => 'Herauszoomen',
        ],
        'helper'    => 'Klicke auf die Karte um einen Link zu einem Ort hinzu zu fügen oder klicke auf einen existierenden Punkt, um ihn zu entfernen.',
        'modal'     => [
            'submit'    => 'Hinzufügen',
            'title'     => 'Ziel des neuen Punkts',
        ],
        'no_map'    => 'Bitte erst eine Karte hinzufügen.',
        'points'    => [
            'fields'        => [
                'axis_x'    => 'X-Achse',
                'axis_y'    => 'Y-Achse',
                'colour'    => 'Farbe',
            ],
            'placeholders'  => [
                'axis_x'    => 'Linke Position',
                'axis_y'    => 'Obere Position',
            ],
            'return'        => 'Zurück zu :name',
            'success'       => [
                'create'    => 'Kartenpunkt für Ort erstellt.',
                'delete'    => 'Kartenpunkt für Ort entfernt.',
                'update'    => 'Kartenpunkt für Ort aktualisiert.',
            ],
            'title'         => 'Ort :name Kartenpunkte',
        ],
        'success'   => 'Kartenpunkte gespeichert.',
    ],
    'placeholders'  => [
        'location'  => 'Wähle einen übergeordneten Ort',
        'name'      => 'Name des Ortes',
        'type'      => 'Stadt, Königreich, Ruine',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Ortes',
        'tabs'          => [
            'characters'    => 'Charaktere',
            'information'   => 'Informationen',
            'locations'     => 'Orte',
            'map'           => 'Karte',
        ],
        'title'         => 'Ort :name',
    ],
];
