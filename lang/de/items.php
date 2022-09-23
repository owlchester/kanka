<?php

return [
    'create'        => [
        'title' => 'Neuen Gegenstand erstellen',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Charakter',
        'image'     => 'Bild',
        'item'      => 'übergeordneter Gegenstand',
        'items'     => 'untergeortneter Gegenstand',
        'location'  => 'Ort',
        'name'      => 'Name',
        'price'     => 'Preis',
        'size'      => 'Größe',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'nested_without'    => 'Alle Gegenstände anzeigen, die keinen übergeordneten Gegenstand haben. Klicke auf eine Zeile, um die untergeordneten Elemente anzuzeigen.',
    ],
    'hints'         => [
        'items' => 'Organisiere Gegenstände mithilfe des übergeordneten Gegenstandfelds.',
    ],
    'index'         => [
        'title' => 'Gegenstände',
    ],
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
