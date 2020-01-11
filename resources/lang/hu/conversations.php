<?php

return [
    'create'        => [
        'description'   => 'Új beszélgetés létrehozása',
        'success'       => '\':name\' beszélgetést létrehoztuk.',
        'title'         => 'Új beszélgetés',
    ],
    'destroy'       => [
        'success'   => '\':name\' beszélgetést eltávolítottuk.',
    ],
    'edit'          => [
        'description'   => 'A beszélgetés frissítése',
        'success'       => '\':name\' beszélgetést frissítettük.',
        'title'         => ':name beszélgetés',
    ],
    'fields'        => [
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
        'description'   => ':name kategória kezelése',
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
        'description'   => 'Résztvevők hozzáadása vagy eltávolítása a beszélgetésből',
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
        'description'   => 'Egy beszélgetés részletes megjelenítése',
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
