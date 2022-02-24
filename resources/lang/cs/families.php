<?php

return [
    'create'        => [
        'success'       => 'Rod ":name" vytvořen.',
        'title'         => 'Nový rod',
    ],
    'destroy'       => [
        'success'   => 'Rod ":name" odstraněn.',
    ],
    'edit'          => [
        'success'   => 'Rod ":name" aktualizován.',
        'title'     => 'Upravit rod :name',
    ],
    'families'      => [
        'title' => 'Rody rodu :name',
    ],
    'fields'        => [
        'families'  => 'Podřazené rody',
        'family'    => 'Nadřazený rod',
        'image'     => 'Obrázek',
        'location'  => 'Místo',
        'members'   => 'Členové',
        'name'      => 'Název',
        'relation'  => 'Vztah',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Seznam zobrazuje všechny rody, podřazené tomuto rodu, nejen přímo podléhající.',
        'nested_parent' => 'Zobrazují se rody podřazené rodu :parent.',
        'nested_without'=> 'Zobrazují se rody bez nadřazeného rodu. Klepnutím na řádek se zobrazí podřazené rody.',
    ],
    'hints'         => [
        'members'   => 'Zde se zobrazují členové rodu. Postavu lze přičlenit některému rodu na její kartě "Rod".',
    ],
    'index'         => [
        'add'           => 'Nový rod',
        'header'        => 'Rody :name',
        'title'         => 'Rody',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Tento seznam obsahuje všechny členy tohoto rodu a jeho podřazených rodů.',
            'direct_members'    => 'Většinu rodů proslavili někteří její členové. Zde je seznam postav, které jsou přímými členy tohoto rodu.',
        ],
        'title'     => 'Členové rodu :name',
    ],
    'placeholders'  => [
        'location'  => 'Vyberte místo',
        'name'      => 'Název rodu',
        'type'      => 'Královský, šlechtický, vymřelý,...',
    ],
    'show'          => [
        'tabs'          => [
            'all_members'   => 'Všichni členové',
            'families'      => 'Rody',
            'members'       => 'Členové',
            'relation'      => 'Vztahy',
        ],
        'title'         => 'Rod :name',
    ],
];
