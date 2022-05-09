<?php

return [
    'abilities'     => [
        'title' => 'Kinderfähigkeiten von :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Fähigkeit zum Objekt hinzufügen',
        ],
        'create'        => [
            'success'   => 'Fähigkeit :name zum Objekt hinzugefügt',
            'title'     => 'Objekt zu :name hinzufügen',
        ],
        'description'   => 'Objekte mit dieser Fähigkeit',
        'title'         => 'Fähigkeit :name Objekt',
    ],
    'create'        => [
        'success'   => 'Fähigkeit \':name\' erstellt',
        'title'     => 'Neue Fähigkeit',
    ],
    'destroy'       => [
        'success'   => 'Fähigkeit \':name\' entfernt',
    ],
    'edit'          => [
        'success'   => 'Fähigkeit \':name\' aktualisiert',
        'title'     => 'Fähigkeit \':name\' bearbeitet',
    ],
    'entities'      => [
        'title' => 'Objekt mit der Fähigkeit :name',
    ],
    'fields'        => [
        'abilities' => 'Fähigkeiten',
        'ability'   => 'Übergeordnete Fähigkeit',
        'charges'   => 'Ladungen',
        'name'      => 'Name',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Diese Liste enthält alle Fähigkeiten, die vererbt werden, und nicht nur diejenigen, die sich auf der nächstniedrigeren Ebene befinden.',
        'nested_parent' => 'Anzeigen der Fähigkeiten von :parent.',
        'nested_without'=> 'Anzeigen aller Fähigkeiten, die keine übergeordnete Fähigkeit haben. Klicken Sie auf eine Zeile, um die Fähigkeiten untergeordneten Objekte anzuzeigen.',
    ],
    'index'         => [
        'title' => 'Fähigkeiten',
    ],
    'placeholders'  => [
        'charges'   => 'Anzahl der Verwendungen. Attribute können mit mit {Level} * {CHA} referenziert werden.',
        'name'      => 'Feuerball, Alarm, listiger Schlag',
        'type'      => 'Zauber, Kraftakt, Attacke',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Fähigkeiten',
            'entities'  => 'Objekte',
        ],
    ],
];
