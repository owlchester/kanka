<?php

return [
    'create'        => [
        'success'   => 'A(z) :name szervezetet létrehoztuk.',
        'title'     => 'Új szervezet',
    ],
    'destroy'       => [
        'success'   => 'A(z) :name szervezetet töröltük.',
    ],
    'edit'          => [
        'success'   => 'A(z) :name szervezetet frissítettük.',
        'title'     => ':name szervezet szerkesztése',
    ],
    'fields'        => [
        'image'         => 'Kép',
        'location'      => 'Helyszín',
        'members'       => 'Tagok',
        'name'          => 'Név',
        'organisation'  => 'Szülőszervezet',
        'organisations' => 'Alszervezet',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'descendants'   => 'Ez a lista a szervezet összes leszármazott szervezetét tartalmazza, nem csak a közvetlen alszervezeit.',
        'nested_parent' => ':parent szervezeteinek mutatása.',
        'nested_without'=> 'Mutass meg minden szervezetet, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekszervezeteit.',
    ],
    'index'         => [
        'title' => 'Szervezetek',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Tag hozzáadása',
        ],
        'create'        => [
            'success'   => 'A tagot hozzáadtuk a szervezethez',
            'title'     => 'Új tag a(z) :name szervezethez',
        ],
        'destroy'       => [
            'success'   => 'A tagot eltávolítottuk a szervezetből',
        ],
        'edit'          => [
            'success'   => 'A szervezeti tagot frissítettük.',
            'title'     => ':name tagjának módosítása',
        ],
        'fields'        => [
            'character'     => 'Karakter',
            'organisation'  => 'Szervezet',
            'role'          => 'Szerep',
        ],
        'helpers'       => [
            'all_members'   => 'Minden karakter, ami tagja ennek a szervezetnek és alszervezeteinek.',
            'members'       => 'Az alábbi listában azok a karakterek szerepelnek, akik vagy tagjai ennek a szervezetnek, vagy tagjai ezen szervezet valamelyik leszármazott szervezetének. Lehetőség van csak a közvetlen tagokra is szűrni.',
        ],
        'placeholders'  => [
            'character' => 'Válassz ki egy karaktert',
            'role'      => 'Vezető, tag, sárkánylovas, zolg',
        ],
        'title'         => ':name tagjai',
    ],
    'organisations' => [
        'title' => ':name alszervezetei',
    ],
    'placeholders'  => [
        'location'  => 'Válassz ki egy helyszínt!',
        'name'      => 'A szervezet neve',
        'type'      => 'Kultusz, banda, klán, fanklub',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Szervezetek',
        ],
    ],
];
