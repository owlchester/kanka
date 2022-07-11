<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Új címke hozzáadása',
        ],
        'create'    => [
            'success'   => ':name cédulát hozzáadtuk az entitáshoz.',
            'title'     => 'Új címke hozzárendelése ehhez: :name',
        ],
        'title'     => ':name címke entitásai',
    ],
    'create'        => [
        'title' => 'Új címke',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Almezők',
        'name'      => 'Megnevezés',
        'tag'       => 'Szülő Címke',
        'tags'      => 'Alcímkék',
        'type'      => 'Típus',
    ],
    'helpers'       => [
        'nested_without'    => 'Minden céldulát megmutat, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekcéduláit.',
    ],
    'hints'         => [
        'children'  => 'Ez a lista felsorol minden, a címkében és annak alcímkéiben közvetlenül szereplő entitást.',
        'tag'       => 'Minden címke, mely közvetlenül ezen címke alatt van.',
    ],
    'index'         => [
        'title' => 'Címkék',
    ],
    'new_tag'       => 'Új címke',
    'placeholders'  => [
        'name'  => 'A címke neve',
        'tag'   => 'Válaszd ki, melyik címkének legyen alcímkéje',
        'type'  => 'Legendák, háborúk, történelem, vallás, címertan',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Alcímkék',
            'tags'      => 'Címkék',
        ],
    ],
    'tags'          => [
        'title' => ':name címke alcímkéi',
    ],
];
