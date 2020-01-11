<?php

return [
    'create'        => [
        'description'   => 'Új tárgy létrehozása',
        'success'       => '\':name\' tárgyat létrehoztuk.',
        'title'         => 'Új tárgy',
    ],
    'destroy'       => [
        'success'   => '\':name\' tárgyat töröltük.',
    ],
    'edit'          => [
        'success'   => '\':name\' tárgyat frissítettük.',
        'title'     => ':name tárgy szerkesztése',
    ],
    'fields'        => [
        'character' => 'Karakter',
        'image'     => 'Kép',
        'location'  => 'Helyszín',
        'name'      => 'Név',
        'price'     => 'Ár',
        'relation'  => 'Kapcsolat',
        'size'      => 'Méret',
        'type'      => 'Típus',
    ],
    'index'         => [
        'add'           => 'Új tárgy',
        'description'   => ':name tárgyainak kezelése',
        'header'        => ':name tárgyai',
        'title'         => 'Tárgyak',
    ],
    'inventories'   => [
        'description'   => 'Entitás Felszerelések, amelyben ez a tárgy szerepel',
        'title'         => ':name tárgy Felszerelései',
    ],
    'placeholders'  => [
        'character' => 'Válassz ki egy karaktert!',
        'location'  => 'Válassz ki egy helyszínt!',
        'name'      => 'A tárgy neve',
        'price'     => 'A tárgy ára',
        'size'      => 'Méret, Súly, Térfogat',
        'type'      => 'Fegyver, bájital, ereklye',
    ],
    'quests'        => [
        'description'   => 'Küldetések, amelyeknek a tárgy része',
        'title'         => ':name tárgy küldetései',
    ],
    'show'          => [
        'description'   => 'Egy tárgy részletei',
        'tabs'          => [
            'information'   => 'Információ',
            'inventories'   => 'Felszerelések',
            'quests'        => 'Küldetések',
        ],
        'title'         => ':name tárgy',
    ],
];
