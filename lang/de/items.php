<?php

return [
    'create'        => [
        'title' => 'Neuen Gegenstand erstellen',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character'     => 'Charakter',
        'is_equipped'   => 'Ausgestattet',
        'price'         => 'Preis',
        'size'          => 'Größe',
        'weight'        => 'Gewicht',
    ],
    'helpers'       => [],
    'hints'         => [
        'items' => 'Organisiere Gegenstände mithilfe des übergeordneten Gegenstandfelds.',
    ],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
        'price' => 'Preis des Gegenstandes',
        'size'  => 'Größe, Gewicht, Maße',
        'type'  => 'Waffe, Trank, Artefakt',
        'weight'=> 'Gewicht des Gegenstands',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Objekte',
        ],
    ],
];
