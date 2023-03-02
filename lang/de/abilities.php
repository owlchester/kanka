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
        'title' => 'Neue Fähigkeit',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Objekt mit der Fähigkeit :name',
    ],
    'fields'        => [
        'abilities' => 'Fähigkeiten',
        'ability'   => 'Übergeordnete Fähigkeit',
        'charges'   => 'Ladungen',
    ],
    'helpers'       => [
        'nested_without'    => 'Anzeigen aller Fähigkeiten, die keine übergeordnete Fähigkeit haben. Klicken Sie auf eine Zeile, um die Fähigkeiten untergeordneten Objekte anzuzeigen.',
    ],
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
            'abilities' => 'Fähigkeiten',
            'entities'  => 'Objekte',
            'reorder'   => 'Fähigkeiten neu anordnen',
        ],
    ],
];
