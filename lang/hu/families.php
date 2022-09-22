<?php

return [
    'create'        => [
        'title' => 'Új család',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [
        'title' => ':name család családjai',
    ],
    'fields'        => [
        'families'  => 'Alcsaládok',
        'family'    => 'Főcsalád',
        'image'     => 'Kép',
        'location'  => 'Helyszín',
        'members'   => 'Tagok',
        'name'      => 'Név',
        'type'      => 'Típus',
    ],
    'helpers'       => [
        'descendants'       => 'Ez a lista a család minden leszármazott családját tartalmazza, nem csak a közvetlenül alatta levőket.',
        'nested_without'    => 'Megmutat minden családot, amelynek nincs szülőcsaládja. Klikkelj egy sorra, hogy meglásd a gyermekcsaládokat.',
    ],
    'hints'         => [
        'members'   => 'Ez a lista a család tagjait tartalmazza. Ha hozzá akarsz adni egy karaktert, nyisd meg a kívánt karaktert szerkesztésre, és használd a "Család" legördülő menüt.',
    ],
    'index'         => [
        'title' => 'Családok',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Az alábbi lista minden karaktert tartalmaz, amely ennek a családnak vagy bármely leszármazott családjának tagja.',
            'direct_members'    => 'Kevés család létezik családtagok nélkül. Az alábbi listában azokat a karaktereket láthatod, akik a család közvetlen tagjai.',
        ],
        'title'     => ':name család tagjai',
    ],
    'placeholders'  => [
        'location'  => 'Válassz ki egy helyszínt!',
        'name'      => 'A család neve',
        'type'      => 'Uralkodói ház, Nemesi ház, Kihalt, stb.',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Minden családtag',
            'families'      => 'Családok',
            'members'       => 'Családtagok',
        ],
    ],
];
