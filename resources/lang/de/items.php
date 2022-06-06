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
        'location'  => 'Ort',
        'name'      => 'Name',
        'price'     => 'Preis',
        'size'      => 'Größe',
        'type'      => 'Typ',
    ],
    'index'         => [
        'title' => 'Gegenstände',
    ],
    'inventories'   => [
        'title' => 'Gegenstand :name Objekte',
    ],
    'placeholders'  => [
        'character' => 'Wähle einen Charakter',
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name des Gegenstands',
        'price'     => 'Preis des Gegenstandes',
        'size'      => 'Größe, Gewicht, Maße',
        'type'      => 'Waffe, Trank, Artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Objekte',
        ],
    ],
];
