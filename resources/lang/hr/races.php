<?php

return [
    'characters'    => [
        'description'   => 'Likovi koji pripadaju toj rasi.',
        'title'         => 'Likovi rase :name',
    ],
    'create'        => [
        'description'   => 'Kreiraj novu rasu',
        'success'       => 'Kreirana rasa ":name".',
        'title'         => 'Nova rasa',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena rasa ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirana rasa ":name".',
        'title'     => 'Uredi rasu :name',
    ],
    'fields'        => [
        'characters'    => 'Likovi',
        'name'          => 'Naziv',
        'race'          => 'Rasa roditelj',
        'races'         => 'Podrase',
        'type'          => 'Tip',
    ],
    'helpers'       => [
        'nested'    => 'U "Ugniježđenom pregledu" možeš vidjeti rase na ugniježđeni način. Rase bez rase roditelj će biti prikazane na osnovnom pregledu. Rase s podrasama se mogu kliknuti kako bi se prikazale te podrase. Možeš nastaviti klikati dok ima podrasa za prikazati.',
    ],
    'index'         => [
        'add'           => 'Nova rasa',
        'description'   => 'Upravljanje rasama u :name',
        'header'        => 'Rase od :name',
        'title'         => 'Rase',
    ],
    'placeholders'  => [
        'name'  => 'Naziv rase',
        'type'  => 'Čovjek, Vila, Borg',
    ],
    'races'         => [
        'description'   => 'Rase koje pripadaju rasi.',
        'title'         => 'Podrase rase :name',
    ],
    'show'          => [
        'description'   => 'Detaljan pregled rase',
        'tabs'          => [
            'characters'    => 'Likovi',
            'menu'          => 'Izbornik',
            'races'         => 'Podrase',
        ],
        'title'         => 'Rasa :name',
    ],
];
