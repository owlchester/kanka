<?php

return [
    'actions'       => [
        'add'   => 'Tárgy hozzáadása',
    ],
    'create'        => [
        'success'   => ':item hozzáadásra került az :entity entitáshoz.',
        'title'     => 'Tárgy hozzáadása a :name entitáshoz',
    ],
    'destroy'       => [
        'success'   => ':item eltávolításra került :entity entitástól.',
    ],
    'fields'        => [
        'amount'        => 'Mennyiség',
        'description'   => 'Leírás',
        'is_equipped'   => 'Felszerelve',
        'name'          => 'Név',
        'position'      => 'Elhelyezés',
    ],
    'placeholders'  => [
        'amount'        => 'Adott mennyiség',
        'description'   => 'Használt, Sérült, Mestermunka, stb.',
        'name'          => 'Szükséges, ha nincs tárgy kiválasztva',
        'position'      => 'Viseli, Hátizsákban, Raktárban, Bankban, stb.',
    ],
    'show'          => [
        'helper'    => 'Entitások rendelkezhetnek hozzájuk rendelt tárgyakkal, így felszerelést alkotva belőlük.',
        'title'     => ':name entitás Felszerelése',
        'unsorted'  => 'Rendezetlen',
    ],
    'update'        => [
        'success'   => ':item tárgy frissítve a(z) :entity entitásban.',
        'title'     => 'Tárgy frissítése :name -en.',
    ],
];
