<?php

return [
    'abilities'     => [
        'title' => 'Underförmågor till :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Lägg till förmåga till entitet',
        ],
        'create'        => [
            'success'   => 'Förmågan :name tillagd till entiteten.',
            'title'     => 'Lägg till en entitet till :name',
        ],
        'description'   => 'Entiteter som har förmågan',
        'title'         => 'Förmåga \':name\' Entiteter',
    ],
    'create'        => [
        'title' => 'Ny Förmåga',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Entiteter med :name förmågan',
    ],
    'fields'        => [
        'abilities' => 'Förmågor',
        'ability'   => 'Huvudförmåga',
        'charges'   => 'Laddningar',
    ],
    'helpers'       => [
        'nested_without'    => 'Visar alla förmågor som inte har en huvudförmåga. Klicka på en rad för att se underförmågor.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Antal laddningar. Referera till egenskaper med {Level}*{CHA}',
        'name'      => 'Eldklot, Alert, Listigt Angrepp',
        'type'      => 'Trollformel, Bedrift, Angrep',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Förmågor',
            'entities'  => 'Entiteter',
        ],
    ],
];
