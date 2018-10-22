<?php

return [
    'characters'    => [
        'description'   => 'Charakter an diesem Ort.',
        'title'         => 'Ort :name Charaktere',
    ],
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
    'events'        => [
        'description'   => 'Ereignisse, die an diesem Ort stattgefunden haben.',
        'title'         => 'Ort :name Ereignisse',
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
    'helpers'       => [
        'nested'    => 'Orte können in einer verschachtelten Ansicht angesehen werden. Orte ohne einen übergeordneten Ort werden direkt angezeigt. Orte, die untergeordnete Orte haben, können angeklickt werden um die untergeordneten Orte anzuzeigen. Du kannst so lange klicken, bis es keine untergeordneten Orte mehr gibt.',
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
    'items'         => [
        'description'   => 'Gegenstände an oder von diesem Ort.',
        'title'         => 'Ort :name Gegenstände',
    ],
    'locations'     => [
        'description'   => 'Orte, die sich an diesem Ort befinden.',
        'title'         => 'Ort :name Orte',
    ],
    'map'           => [
        'actions'   => [
            'big'           => 'Vollansicht',
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
                'name'      => 'Markierung',
            ],
            'helpers'       => [
                'location_or_name'  => 'Eine Karte kann zu einem bestehenden Ort verlinken oder einfach nur eine Markierung haben.',
            ],
            'placeholders'  => [
                'axis_x'    => 'Linke Position',
                'axis_y'    => 'Obere Position',
                'name'      => 'Markierung des Punktes, wenn kein Ort angegeben ist.',
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
    'organisations' => [
        'description'   => 'Organisationen in diesem Ort.',
        'title'         => 'Ort :name Organisationen',
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
            'events'        => 'Ereignisse',
            'information'   => 'Informationen',
            'items'         => 'Gegenstände',
            'locations'     => 'Orte',
            'map'           => 'Karte',
            'menu'          => 'Menü',
            'organisations' => 'Organisationen',
        ],
        'title'         => 'Ort :name',
    ],
];
