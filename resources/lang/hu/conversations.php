<?php

return [
    'create'        => [
        'success'       => '\':name\' beszélgetést létrehoztuk.',
        'title'         => 'Új beszélgetés',
    ],
    'destroy'       => [
        'success'   => '\':name\' beszélgetést eltávolítottuk.',
    ],
    'edit'          => [
        'success'       => '\':name\' beszélgetést frissítettük.',
        'title'         => ':name beszélgetés',
    ],
    'fields'        => [
        'is_closed'     => 'Lezárva',
        'messages'      => 'Üzenetek',
        'name'          => 'Megnevezés',
        'participants'  => 'Résztvevők',
        'target'        => 'Célpont',
        'type'          => 'Típus',
    ],
    'hints'         => [
        'participants'  => 'Kérjük, adj résztvevőket a beszélgetésedhez az :icon ikonra kattintva a jobb felső részen.',
    ],
    'index'         => [
        'add'           => 'Új beszélgetés',
        'header'        => 'Beszélgetés itt: :name',
        'title'         => 'Beszélgetés',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Üzenet eltávolítva.',
        ],
        'is_updated'    => 'Frissítve',
        'load_previous' => 'Előző üzenet betöltése',
        'placeholders'  => [
            'message'   => 'Üzeneted',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => ':entity résztvevőt hozzáadtuk a beszélgetéshez.',
        ],
        'destroy'       => [
            'success'   => ':entity résztvevőt eltávolítottuk a beszélgetésből.',
        ],
        'modal'         => 'Résztvevők',
        'title'         => ':name résztvevői',
    ],
    'placeholders'  => [
        'name'  => 'A beszélgetés megnevezése',
        'type'  => 'Játékbeli, előkészület, cselekmény',
    ],
    'show'          => [
        'is_closed'     => 'A beszélgetést lezártuk.',
        'title'         => ':name beszélgetés',
    ],
    'tabs'          => [
        'conversation'  => 'Beszélgetés',
        'participants'  => 'Résztvevők',
    ],
    'targets'       => [
        'characters'    => 'Karakterek',
        'members'       => 'Tagok',
    ],
];
