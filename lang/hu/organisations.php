<?php

return [
    'create'        => [
        'title' => 'Új szervezet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'members'   => 'Tagok',
    ],
    'helpers'       => [
        'descendants'       => 'Ez a lista a szervezet összes leszármazott szervezetét tartalmazza, nem csak a közvetlen alszervezeit.',
        'nested_without'    => 'Mutass meg minden szervezetet, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekszervezeteit.',
    ],
    'index'         => [],
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
            'role'  => 'Szerep',
        ],
        'helpers'       => [
            'all_members'   => 'Minden karakter, ami tagja ennek a szervezetnek és alszervezeteinek.',
            'members'       => 'Az alábbi listában azok a karakterek szerepelnek, akik vagy tagjai ennek a szervezetnek, vagy tagjai ezen szervezet valamelyik leszármazott szervezetének. Lehetőség van csak a közvetlen tagokra is szűrni.',
        ],
        'placeholders'  => [
            'role'  => 'Vezető, tag, sárkánylovas, zolg',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Kultusz, banda, klán, fanklub',
    ],
    'show'          => [],
];
