<?php

return [
    'actions'       => [
        'return'        => 'Vissza az összes eseményhez',
        'send'          => 'Részvétel',
        'show_ongoing'  => 'Események és résztvevők megtekintése',
        'show_past'     => 'Események és győztesek megtekintése',
        'update'        => 'Beadvány frissítése',
        'view'          => 'Beadvány megtekintése',
    ],
    'description'   => 'Gyakori világépítési eseményeket szervezünk a közösségnek, bemutatva a kedvenc bejegyzéseinket.',
    'fields'        => [
        'comment'       => 'Komment',
        'entity_link'   => 'Link az entitáshoz',
        'honorable'     => 'Elismerő említés',
        'rank'          => 'Rang',
        'submitter'     => 'Benyújtó',
    ],
    'index'         => [
        'ongoing'   => 'Folyamatban lévő esemény',
        'past'      => 'Lezárult esemény',
    ],
    'participate'   => [
        'description'   => 'Inspirált ez az esemény? Hozz létre egy entitást egy publikus kampányodban, és küldd be nekünk a linkjét a lenti űrlapon. Bármikor megváltoztathatod vagy törölheted a beadványodat.',
        'login'         => 'Lépj be a fiókodba, hogy részt vegyél az eseményben.',
        'participated'  => 'Már küldtél beadványt erre az eseményre. Szerkesztheted vagy eltávolíthatod azt.',
        'success'       => [
            'modified'  => 'A beadványod változtatásait elmentettük.',
            'removed'   => 'A beadványodat eltávolítottuk.',
            'submit'    => 'A beadványodat beküldted. Bármikor szerkesztheted vagy eltávolíthatod.',
        ],
        'title'         => 'Részvétel az eseményben',
    ],
    'placeholders'  => [
        'comment'       => 'Kommentek a beadványodhoz (opcionális)',
        'entity_link'   => 'Másold ide az entitás linkjét',
    ],
    'results'       => [
        'description'       => 'A zsűrink az alábbi beadványokat választotta győztesnek az eseményben.',
        'scheduled'         => 'Ez az esemény ekkor indul: :start',
        'title'             => 'Az esemény győztesei',
        'waiting_results'   => 'Az eseménynek vége! Az esemény zsűrije átnézi a beadványokat, és nem sokára győztest hirdet, őket majd itt láthatod.',
    ],
    'show'          => [
        'participants'  => '{1} :number beadvány beküldve.|[2,*] :number beadvány beküldve.',
        'title'         => ':name esemény',
    ],
    'title'         => 'Események',
];
