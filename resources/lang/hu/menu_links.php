<?php

return [
    'create'        => [
        'success'   => '\':name\' menühivatkozást létrehoztuk.',
        'title'     => 'Új menühivatkozás',
    ],
    'destroy'       => [
        'success'   => '\':name\' menühivatkozást töröltük.',
    ],
    'edit'          => [
        'success'   => '\':name\' menühivatkozást frissítettük.',
        'title'     => ':name menühivatkozás',
    ],
    'fields'        => [
        'dashboard'     => 'Főoldal',
        'entity'        => 'Entitás',
        'filters'       => 'Szűrők',
        'is_nested'     => 'Beágyazott',
        'menu'          => 'Menü',
        'name'          => 'Név',
        'position'      => 'Elhelyezés',
        'random'        => 'Véletlenszerű',
        'random_type'   => 'Véletlen entitástípus',
        'selector'      => 'Gyors linkkonfigurálás',
        'tab'           => 'Lapfül',
        'type'          => 'Entitás típusa',
    ],
    'helpers'       => [
        'dashboard' => 'Legyen egy gyorslinekd a kampány egyik egyéni főoldalához.',
        'entity'    => 'Hozz létre egy menü hivatkozást egy entitás közvetlen eléréséhez. A :tab mező meghatározza, hogy melyik fül legyen kiválasztva. A :menu mező azt befolyásolja, hogy melyik oldalrész legyen megnyitva.',
        'position'  => 'Használd ezt a mezőt, a menühivatkozások sorrendjének meghatározásához. A rendezés az itt beállított számok alapján, növekvő sorrendben történik majd.',
        'random'    => 'Arra használd ezt a mezőt, hogy gyorsan elérj egy véletlenszerű entitást. Szűrheted a linket, hogy csak egy bizonyos típusú entitásra mutasson.',
        'selector'  => 'Állítsd be, hogy hová mutasson ez a link, amikor a felhasználók ráklikkelnek az oldalsávon.',
        'type'      => 'Hozz létre egy menü hivatkozást entitások listájának közvetlen eléréséhez. A találatok szűréséhez másold a szűrt entitás lista url-jének azon részét a :filter mezőbe, amely a :? karakter után következik.',
    ],
    'index'         => [
        'add'   => 'Új menühivatkozás',
        'title' => 'Menühivatkozások',
    ],
    'placeholders'  => [
        'entity'    => 'Válassz ki egy entitást',
        'filters'   => 'location_id=15&type=város',
        'menu'      => 'Menü aloldal (az url utolsó szöveges része)',
        'name'      => 'A menühivatkozás neve',
        'tab'       => 'bejegyzés, hivatkozások, jegyzetek',
    ],
    'random_types'  => [
        'any'   => 'Bármelyik entitás',
    ],
    'show'          => [],
];
