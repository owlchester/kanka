<?php

return [
    'actions'       => [
        'add'   => 'Új réteg hozzáadása',
    ],
    'base'          => 'Alap réteg',
    'create'        => [
        'success'   => ':name réteg létrejött!',
        'title'     => 'Új réteg',
    ],
    'delete'        => [
        'success'   => ':name réteg törlésre került.',
    ],
    'edit'          => [
        'success'   => ':name réteg frissült.',
        'title'     => ':name réteg szerkesztése',
    ],
    'fields'        => [
        'position'  => 'Elhelyezkedés',
    ],
    'helper'        => [
        'amount'            => 'Legfeljebb :amount db réteget rendelhetsz egy térképhez, amelyek között váltogatva más-más kép jelenik meg a térképjelzők alatt.',
        'boosted_campaign'  => ':boosted kampány rendelkezhet :amound db réteggel.',
    ],
    'placeholders'  => [
        'name'      => 'Pince, 2-ik emelet, Hajóroncs',
        'position'  => 'Opcionális mező annak meghatározására, hogy az egyes rétegek milyen sorrendben jelenjenek meg.',
    ],
];
