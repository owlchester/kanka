<?php

return [
    'actions'       => [
        'add'   => 'Pridaj Predmet',
    ],
    'create'        => [
        'success'   => 'Predmet :item pridaný do :entity.',
        'title'     => 'Pridaj Predmet ku :name',
    ],
    'destroy'       => [
        'success'   => 'Predmet :name odstránený z :entity.',
    ],
    'fields'        => [
        'amount'        => 'Počet',
        'description'   => 'Popis',
        'is_equipped'   => 'Vybavený',
        'name'          => 'Názov',
        'position'      => 'Umiestnenie',
    ],
    'placeholders'  => [
        'amount'        => 'Hocijaké množstvo',
        'description'   => 'Použitý, Zničený, Zžitý',
        'name'          => 'Potrebný, ak nie je zvolený žiaden objekt',
        'position'      => 'V rukách, V ruksaku, V sklade, V banke',
    ],
    'show'          => [
        'helper'    => 'Objekty môžu mať priradené Predmety, čím sa vytvára ich Inventár.',
        'title'     => 'Objekt :name Inventár',
        'unsorted'  => 'Nezoradené',
    ],
    'update'        => [
        'success'   => 'Predmet :item pre :entity upravený.',
        'title'     => 'Uprav Predmet :name',
    ],
];
