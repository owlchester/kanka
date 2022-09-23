<?php

return [
    '403'       => [
        'body'  => 'Izgleda da nemaš dozvolu za pristup ovoj stranici!',
        'title' => 'Dozvola odbijena',
    ],
    '403-form'  => [
        'help'  => 'Ovo bi moglo biti zbog isteka sesije. Prije spremanja, pokušaj se ponovo prijaviti u drugom prozoru.',
    ],
    '404'       => [
        'body'  => 'Nažalost, stranicu koju tražiš nije moguće pronaći.',
        'title' => 'Stranica nije pronađena',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Ups, izgleda da je nešto pošlo po zlu.',
            '2' => 'Izvješće s nađenom pogreškom nam je poslano, ali ponekad pomaže ako možemo znati malo više o tome što si radio/la.',
        ],
        'title' => 'Pogreška',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka se trenutno održava, što obično znači da je u tijeku ažuriranje!',
            '2' => 'Oprosti na neugodnosti. Sve će se vratiti u normalu u samo nekoliko minuta.',
        ],
        'title' => 'Održavanje',
    ],
    '503-form'  => [],
    'footer'    => 'Ako ti je potrebna dodatna pomoć, kontaktiraj nas na hello@kanka.io ili na :discord',
];
