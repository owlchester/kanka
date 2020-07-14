<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Új címke hozzáadása',
        ],
        'create'        => [
            'title' => 'Új címke hozzárendelése ehhez: :name',
        ],
        'description'   => 'A címkéhez tartozó entitások',
        'title'         => ':name címke entitásai',
    ],
    'create'        => [
        'description'   => 'Új címke létrehozása',
        'success'       => 'A \':name\' címkét létrehoztuk',
        'title'         => 'Új címke',
    ],
    'destroy'       => [
        'success'   => 'A \':name\' címkét eltávolítottuk',
    ],
    'edit'          => [
        'success'   => 'A \':name\' címkét frissítettük',
        'title'     => ':name címke szerkesztése',
    ],
    'fields'        => [
        'characters'    => 'Karakterek',
        'children'      => 'Almezők',
        'name'          => 'Megnevezés',
        'tag'           => 'Szülő Címke',
        'tags'          => 'Alcímkék',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'nested'    => 'Hierarchikus nézetben a címkéidet azok alá-fölérendeltségi viszonya szerint láthatod. Az első oldalon azok a címkék jelennek meg, melyek nem alcímkéi másoknak. Az alcímkékkel rendelkező címkékre kattintva megtekintheted azok alcímkéit, lefelé haladva amíg nincs több megtekinthető alcímke.',
    ],
    'hints'         => [
        'children'  => 'Ez a lista felsorol minden, a címkében és annak alcímkéiben közvetlenül szereplő entitást.',
        'tag'       => 'Minden címke, mely közvetlenül ezen címke alatt van.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Hierarchikus nézet',
        ],
        'add'           => 'Új címke',
        'description'   => ':name címkéinek kezelése',
        'header'        => ':name címkéi',
        'title'         => 'Címkék',
    ],
    'new_tag'       => 'Új címke',
    'placeholders'  => [
        'name'  => 'A címke neve',
        'tag'   => 'Válaszd ki, melyik címkének legyen alcímkéje',
        'type'  => 'Legendák, háborúk, történelem, vallás, címertan',
    ],
    'show'          => [
        'description'   => 'Egy címke részletes nézete',
        'tabs'          => [
            'children'      => 'Alcímkék',
            'information'   => 'Információ',
            'tags'          => 'Címkék',
        ],
        'title'         => ':name címke',
    ],
    'tags'          => [
        'description'   => 'Alcímkék',
        'title'         => ':name címke alcímkéi',
    ],
];
