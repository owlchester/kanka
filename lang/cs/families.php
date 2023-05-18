<?php

return [
    'create'        => [
        'title' => 'Nový rod',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Členové',
    ],
    'helpers'       => [
        'descendants'       => 'Seznam zobrazuje všechny rody, podřazené tomuto rodu, nejen přímo podléhající.',
        'nested_without'    => 'Zobrazují se rody bez nadřazeného rodu. Klepnutím na řádek se zobrazí podřazené rody.',
    ],
    'hints'         => [
        'members'   => 'Zde se zobrazují členové rodu. Postavu lze přičlenit některému rodu na její kartě "Rod".',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Tento seznam obsahuje všechny členy tohoto rodu a jeho podřazených rodů.',
            'direct_members'    => 'Většinu rodů proslavili někteří její členové. Zde je seznam postav, které jsou přímými členy tohoto rodu.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Název rodu',
        'type'  => 'Královský, šlechtický, vymřelý,...',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Členové',
        ],
    ],
];
