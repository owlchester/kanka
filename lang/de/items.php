<?php

return [
    'create'        => [
        'title' => 'Neuen Gegenstand erstellen',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Charakter',
        'item'      => 'übergeordneter Gegenstand',
        'items'     => 'untergeortneter Gegenstand',
        'price'     => 'Preis',
        'size'      => 'Größe',
    ],
    'helpers'       => [
        'nested_without'    => 'Alle Gegenstände anzeigen, die keinen übergeordneten Gegenstand haben. Klicke auf eine Zeile, um die untergeordneten Elemente anzuzeigen.',
    ],
    'hints'         => [
        'items' => 'Organisiere Gegenstände mithilfe des übergeordneten Gegenstandfelds.',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => 'Gegenstand :name Objekte',
    ],
    'placeholders'  => [
        'name'  => 'Name des Gegenstands',
        'price' => 'Preis des Gegenstandes',
        'size'  => 'Größe, Gewicht, Maße',
        'type'  => 'Waffe, Trank, Artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Objekte',
        ],
    ],
];
