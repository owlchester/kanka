<?php

return [
    'create'        => [
        'success'   => ':name új kapcsolatát létrehoztuk.',
        'title'     => 'Kapcsolatok létrehozása',
    ],
    'destroy'       => [
        'success'   => ':name kapcsolatát eltávolítottuk.',
    ],
    'fields'        => [
        'attitude'  => 'Hozzáállás',
        'is_star'   => 'Rögzítve',
        'relation'  => 'Kapcsolat',
        'target'    => 'Célpont',
        'two_way'   => 'Tükörkapcsolat létrehozása',
    ],
    'helper'        => 'Állíts be kapcsolatot entitások között hozzáállás mértékét, és a kapcsolat láthatóságát is beállítva. A kapcsolatok ki is rögzíthetőek az entitás menüjére.',
    'hints'         => [
        'attitude'  => 'Ez az opcionális mező arra használható, hogy kiválaszd, hogy mely jellemző alapján legyenek csökkenő sorrendben rendezve a Kapcsolatok.',
        'mirrored'  => [
            'text'  => 'Tükörkapcsolatban van ezzel :link.',
            'title' => 'Tükörkapcsolatban',
        ],
        'two_way'   => 'Ha kiválasztod a tükörkapcsolat létrehozását, a célponton is létrejön ugyanez a kapcsolat - azonban ha az egyiket szerkeszted, a tükörképe nem fog frissülni.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 és 100 közé eső érték, ahol 100 nagyon pozitív kapcsolatot reprezentál.',
        'relation'  => 'A kapcsolat jellege',
        'target'    => 'Válassz ki egy entitást!',
    ],
    'show'          => [
        'title' => ':name kapcsolatai',
    ],
    'update'        => [
        'success'   => ':name kapcsolatát frissítettük.',
        'title'     => 'Kapcsolatok módosítása',
    ],
];
