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
        'success'   => 'Förmåga \':name\' skapad.',
        'title'     => 'Ny Förmåga',
    ],
    'destroy'       => [
        'success'   => 'Förmåga \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Förmåga \':name\' uppdaterad.',
        'title'     => 'Redigera Förmåga :name',
    ],
    'entities'      => [
        'title' => 'Entiteter med :name förmågan',
    ],
    'fields'        => [
        'abilities' => 'Förmågor',
        'ability'   => 'Huvudförmåga',
        'charges'   => 'Laddningar',
        'name'      => 'Namn',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Denna lista innehåller alla förmågor som har härletts från denna förmåga, och inte bara de direkt under denna.',
        'nested_parent' => 'Visar förmågor för :parent.',
        'nested_without'=> 'Visar alla förmågor som inte har en huvudförmåga. Klicka på en rad för att se underförmågor.',
    ],
    'index'         => [
        'add'       => 'Ny Förmåga',
        'header'    => 'Förmågor till :name',
        'title'     => 'Förmågor',
    ],
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
        'title' => 'Förmåga :name',
    ],
];
