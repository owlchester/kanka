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
        'position'      => 'Umiestnenie',
    ],
    'placeholders'  => [
        'amount'        => 'Hocijaké množstvo',
        'description'   => 'Použitý, Zničený, Zžitý',
        'position'      => 'V rukách, V ruksaku, V sklade, V banke',
    ],
    'show'          => [
        'helper'    => 'Objekty môžu mať priradené Predmety, čím sa vytvára ich Inventár.',
        'title'     => 'Objekt :name Inventár',
    ],
    'update'        => [
        'success'   => 'Predmet :item pre :entity upravený.',
        'title'     => 'Uprav Predmet :name',
    ],
];
