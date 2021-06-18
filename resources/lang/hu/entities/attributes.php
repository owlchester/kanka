<?php

return [
    'actions'       => [
        'add'               => 'Tulajdonság hozzáadása',
        'add_block'         => 'Blokk hozzáadása',
        'add_checkbox'      => 'Jelölőnégyzet hozzáadása',
        'add_text'          => 'Szöveg hozzáadása',
        'apply_template'    => 'Tulajdonságsablon alkalmazása',
        'manage'            => 'Kezelés',
        'remove_all'        => 'Összes törlése',
    ],
    'create'        => [
        'description'   => 'Új tulajdonság létrehozása',
        'success'       => ':name tulajdonságot hozzáadtuk :entity entitáshoz.',
        'title'         => ':name entitáshoz új tulajdonság hozzáadása',
    ],
    'destroy'       => [
        'success'   => ':entity :name tulajdonságát eltávolítottuk.',
    ],
    'edit'          => [
        'description'   => 'Létező entitás frissítése',
        'success'       => ':entity :name tulajdonságát frissítettük.',
        'title'         => ':name tulajdonságnak frissítése',
    ],
    'fields'        => [
        'attribute'             => 'Tulajdonság',
        'community_templates'   => 'Közösségi sablonok',
        'is_private'            => 'Privát Tulajdonságok',
        'is_star'               => 'Kitűzve',
        'template'              => 'Sablon',
        'value'                 => 'Érték',
    ],
    'helpers'       => [
        'delete_all'    => 'Biztosan ki akarod törölni az entitás összes tulajdonságát?',
    ],
    'hints'         => [
        'is_private'    => 'Elrejtheted egy entitás összes tulajdonságát az összes, nem-admin szerepű felhasználó elől, úgy, hogy priváttá teszed őket.',
    ],
    'index'         => [
        'success'   => ':entity számára frissítettük a tulajdonságokat.',
        'title'     => 'Tulajdonságok :name számára',
    ],
    'placeholders'  => [
        'attribute' => 'Hódítások száma, Kihívási érték, kezdeményezés, népesség',
        'block'     => 'Blokk megnevezése',
        'checkbox'  => 'Jelölőnégyzet megnevezése',
        'section'   => 'Szakasz neve',
        'template'  => 'Válassz ki egy sablont!',
        'value'     => 'A tulajdonság értéke',
    ],
    'template'      => [
        'success'   => ':name tulajdonságsablont alkalmaztuk :entity entátáshoz.',
        'title'     => ':name számára tulajdonságsablon alkalmazása',
    ],
    'types'         => [
        'attribute' => 'Tulajdonság',
        'block'     => 'Blokk',
        'checkbox'  => 'Jelölőnégyzet',
        'section'   => 'Szakasz',
        'text'      => 'Többsoros szöveg',
    ],
    'visibility'    => [
        'entry'     => 'A tulajdonság megjelenik az entitás menüjén',
        'private'   => 'A tulajdonság csak az "Admin" szerepű tagok számára látható.',
        'public'    => 'A tulajdonság minden tag számára látható.',
        'tab'       => 'A tulajdonság csak a Tulajdonságok fülön jelenik meg.',
    ],
];
