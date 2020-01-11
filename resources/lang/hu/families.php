<?php

return [
    'create'        => [
        'description'   => 'Új család létrehozása',
        'success'       => '\':name\' családot létrehoztuk.',
        'title'         => 'Új család',
    ],
    'destroy'       => [
        'success'   => '\':name\' családot töröltük.',
    ],
    'edit'          => [
        'success'   => '\':name\' családot frissítettük.',
        'title'     => ':name család szerkesztése',
    ],
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
        'relation'  => 'Kapcsolatok',
        'type'      => 'Típus',
    ],
    'helpers'       => [
        'descendants'   => 'Ez a lista a család minden leszármazott családját tartalmazza, nem csak a közvetlenül alatta levőket.',
        'nested'        => 'Hierarchikus nézetben a családjaidat alá-fölé rendeltségi viszonyukban láthatod. Alapesetben azokat a családokat látod, amelyek nem alcsaládjai másoknak. Az alcsaládokkal rendelkező családokra kattintva az alcsaládjai listáját láthatod, amelyek -  amennyiben vannak saját alcsaládjaik - szintén kattinthatóak.',
    ],
    'hints'         => [
        'members'   => 'Ez a lista a család tagjait tartalmazza. Ha hozzá akarsz adni egy karaktert, nyisd meg a kívánt karaktert szerkesztésre, és használd a "Család" legördülő menüt.',
    ],
    'index'         => [
        'add'           => 'Új család',
        'description'   => ':name családjainak kezelése',
        'header'        => ':name családja',
        'title'         => 'Családok',
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
        'description'   => 'Egy család részletes nézete',
        'tabs'          => [
            'all_members'   => 'Minden családtag',
            'families'      => 'Családok',
            'members'       => 'Családtagok',
            'relation'      => 'Kapcsolatok',
        ],
        'title'         => ':name család',
    ],
];
