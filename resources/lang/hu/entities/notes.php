<?php

return [
    'actions'       => [
        'add'       => 'Jegyzet hozzáadása',
        'add_role'  => 'Új szerep hozzáadása',
        'add_user'  => 'Felhasználó hozzáadása',
    ],
    'create'        => [
        'success'       => '\':name\' jegyzetet hozzáadtuk :entity entitáshoz.',
        'title'         => 'Új jegyzet :name számára',
    ],
    'destroy'       => [
        'success'   => '\':name\' jegyeztet eltávolítottuk :entity entitásból.',
    ],
    'edit'          => [
        'success'       => '\':name\' jegyzetet frissítettük :entity entitás számára.',
        'title'         => 'Jegyzet frissítése :name számára',
    ],
    'fields'        => [
        'collapsed' => 'Entitás megjegyzés összecsukása alapértelmezettre',
        'creator'   => 'Létrehozó',
        'entry'     => 'Bejegyzés',
        'name'      => 'Név',
    ],
    'footer'        => [
        'created'   => ':user hozta létre ekkor: :date',
        'updated'   => ':user frissítette ekkor: :date',
    ],
    'hint'          => 'Olyan információkat, amelyek nem passzolnak bele a sztenderd mezőkbe, vagy amit privátként szeretnél megjeleníteni, jegyzetként lehet létrehozni.',
    'hints'         => [
        'reorder'   => 'Átrendezheted egy entitás megjegyzéseit az :icon ikonra kattintva az entitás menüjében.',
    ],
    'index'         => [
        'title' => 'Jegyzetek :name számára',
    ],
    'placeholders'  => [
        'name'  => 'A jegyzet megnevezése.',
    ],
    'show'          => [
        'advanced'  => 'Bővebb engedélyek',
        'title'     => ':name jegyzet :entity számára',
    ],
];
