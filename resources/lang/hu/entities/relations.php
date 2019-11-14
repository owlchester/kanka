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
        'relation'  => 'Kapcsolat',
        'target'    => 'Célpont',
        'two_way'   => 'Tükörkapcsolat létrehozása',
    ],
    'hints'         => [
        'two_way'   => 'Ha kiválasztod a tükörkapcsolat létrehozását, a célponton is létrejön ugyanez a kapcsolat - azonban ha az egyiket szerkeszted, a tükörképe nem fog frissülni.',
    ],
    'placeholders'  => [
        'relation'  => 'A kapcsolat jellege',
        'target'    => 'Válassz ki egy entitást!',
    ],
    'update'        => [
        'success'   => ':name kapcsolatát frissítettük.',
        'title'     => 'Kapcsolatok módosítása',
    ],
];
