<?php

return [
    'actions'       => [
        'accept'    => 'Elfogadás',
        'reject'    => 'Elutasítás',
    ],
    'apply'         => [
        'apply'         => 'Alkalmazás',
        'help'          => 'Ez a kapmány nyitott új tagok számára. Kérheted a csatlakozást az űrlap kitöltésével. Értesítünk, amikor a kampány adminisztrátora elbírálja a kérelmedet.',
        'remove_text'   => 'kérelmed',
        'success'       => [
            'apply' => 'Kérelmedet elmentettük. Megváltoztathatod vagy törölheted bármikor. Értesítünk, amikor a kampány adminisztrátora elbírálja.',
            'remove'=> 'Kérelmedet eltávolítottuk.',
            'update'=> 'Kérelmedet frissítettük. Megváltoztathatod vagy törölheted bármikor. Értesítünk, amikor a kampány adminisztrátora elbírálja.',
        ],
        'title'         => 'Csatlakozás ehhez: :name',
    ],
    'errors'        => [
        'not_open'  => 'Ez a kampány nem nyitott új tagok számára. Állítsd át a kampányt, ha szeretnéd megengedni, hogy felhasználók csatlakozási kérelmet írhassanak.',
    ],
    'fields'        => [
        'application'   => 'Kérelem',
        'rejection'     => 'Elutasítás oka',
    ],
    'helpers'       => [
        'open_and_public'   => 'A kampány elfogadja a csatlakozási kérelmeket. Ha meg akarod ezt változtatni, a Nyílt beállítást kell átállítani a :tab fülön.',
    ],
    'placeholders'  => [
        'note'  => 'Írd ide a csatlakozási kérelmedet.',
    ],
    'title'         => 'Kampány csatlakozási kérelmei',
    'update'        => [
        'approve'   => 'Válaszd ki, hogy milyen szereppel adod hozzá a felhasználót a kampányodhoz.',
        'approved'  => 'Csatalkozási kérelem elfogadva.',
        'reject'    => 'Írj egy rövid, nem kötelező üzenetet, hogy miért utasítottad el.',
        'rejected'  => 'Csatlakozási kérelem elutasítva.',
    ],
];
