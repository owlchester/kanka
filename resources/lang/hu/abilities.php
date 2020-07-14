<?php

return [
    'abilities'     => [
        'title' => ':name leszármazott képességei',
    ],
    'create'        => [
        'success'   => '":name" képességet létrehoztuk.',
        'title'     => 'Új képesség',
    ],
    'destroy'       => [
        'success'   => '":name" képességet eltávolítottuk.',
    ],
    'edit'          => [
        'success'   => '":name" képességet frissítettük.',
        'title'     => ':name képesség szerkesztése',
    ],
    'fields'        => [
        'abilities' => 'Képességek',
        'ability'   => 'Szülő Képesség',
        'charges'   => 'Aktiválások száma',
        'name'      => 'Megnevezés',
        'type'      => 'Típus',
    ],
    'helpers'       => [
        'descendants'   => 'Ez a lista minden olyan képességet tartalmaz, amelyek ennek a képességnek a leszármazottai, és nem csak azok, amelyek közvetlenül alá tartoznak.',
        'nested'        => 'Összevont nézetben összevontan látod a képességeidet. A szülő képességgel nem rendelkező képességek az alapbeállítás szerint láthatók. Az alképességekkel rendelkező képességekre rá lehet kattintani, hogy megnézzük a leszármazott képességeit. Folytathatod a kattintást, amíg vannak leszármazott képességek.',
    ],
    'index'         => [
        'add'           => 'Új képesség',
        'description'   => 'Erő, varázslat, képesség és egyéb különlegesség az entitásodhoz.',
        'header'        => ':name képességei',
        'title'         => 'Képességek',
    ],
    'placeholders'  => [
        'charges'   => 'Aktiválások száma. Az attribútumokra az alábbi módon hivatkozhatsz: {Szint}*{Karizma}',
        'name'      => 'Tűzgolyó, riasztás, ravasz csapás',
        'type'      => 'Varázslat, képesség, támadás',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Képességek',
        ],
        'title' => ':name képesség',
    ],
];
