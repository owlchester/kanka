<?php

return [
    'create'        => [
        'title' => 'Nový rozhovor',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_closed'     => 'Uzavřený',
        'messages'      => 'Zprávy',
        'participants'  => 'Účastníci',
    ],
    'hints'         => [
        'participants'  => 'Účastníky rozhovoru přidáš klepnutím na ikonu :icon vpravo nahoře.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Zpráva odstraněna',
        ],
        'is_updated'    => 'Aktualizováno',
        'load_previous' => 'Načíst předchozí zprávy',
        'placeholders'  => [
            'message'   => 'Tvá zpráva',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Postava :entity se nyní účastní rozhovoru.',
        ],
        'destroy'   => [
            'success'   => 'Postava :entity se nadále neúčastní rozhovoru.',
        ],
        'modal'     => 'Účastníci',
        'title'     => 'Účastníci rozhovoru :name',
    ],
    'placeholders'  => [
        'name'  => 'Název rozhovoru',
        'type'  => 'Ve hře, příprava, námět',
    ],
    'show'          => [
        'is_closed' => 'Rozhovor skončil',
    ],
    'tabs'          => [
        'participants'  => 'Účastníci',
    ],
    'targets'       => [
        'characters'    => 'Postavy',
        'members'       => 'Členové',
    ],
];
