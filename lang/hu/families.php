<?php

return [
    'create'        => [
        'title' => 'Új család',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Tagok',
    ],
    'helpers'       => [],
    'hints'         => [
        'members'   => 'Ez a lista a család tagjait tartalmazza. Ha hozzá akarsz adni egy karaktert, nyisd meg a kívánt karaktert szerkesztésre, és használd a "Család" legördülő menüt.',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Az alábbi lista minden karaktert tartalmaz, amely ennek a családnak vagy bármely leszármazott családjának tagja.',
            'direct_members'    => 'Kevés család létezik családtagok nélkül. Az alábbi listában azokat a karaktereket láthatod, akik a család közvetlen tagjai.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'A család neve',
        'type'  => 'Uralkodói ház, Nemesi ház, Kihalt, stb.',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Családtagok',
        ],
    ],
];
