<?php

return [
    'create'        => [
        'description'   => 'Új jegyzet létrehozása',
        'success'       => 'A(z) :name jegyzetet létrehoztuk.',
        'title'         => 'Új jegyzet',
    ],
    'destroy'       => [
        'success'   => 'A(z) :name jegyzetet töröltük.',
    ],
    'edit'          => [
        'success'   => 'A(z) :name jegyzetet frissítettük.',
        'title'     => ':name jegyzet szerkesztése',
    ],
    'fields'        => [
        'description'   => 'Leírás',
        'image'         => 'Kép',
        'is_pinned'     => 'Kiemelt',
        'name'          => 'Név',
        'type'          => 'Típus',
    ],
    'hints'         => [
        'is_pinned' => 'A vezérlőpultra legfeljebb három jegyzetet emelhetsz ki.',
    ],
    'index'         => [
        'add'           => 'Új jegyzet',
        'description'   => ':name jegyzeteinek kezelése',
        'header'        => ':name jegyzetei',
        'title'         => 'Jegyzetek',
    ],
    'placeholders'  => [
        'name'  => 'A jegyzet neve',
        'type'  => 'Vallás, faj, politikai rendszer',
    ],
    'show'          => [
        'description'   => 'A jegyzet részletes nézete',
        'tabs'          => [
            'description'   => 'Leírás',
        ],
        'title'         => ':name',
    ],
];
