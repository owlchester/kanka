<?php

return [
    'create'        => [
        'description'   => 'Stvori novu bilješku',
        'success'       => 'Kreirana bilješka ":name".',
        'title'         => 'Nova bilješka',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena bilješka ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirana bilješka ":name".',
        'title'     => 'Uredi bilješku :name',
    ],
    'fields'        => [
        'description'   => 'Opis',
        'image'         => 'Slika',
        'is_pinned'     => 'Pričvršćena',
        'name'          => 'Naslov',
        'type'          => 'Tip',
    ],
    'hints'         => [
        'is_pinned' => 'Do 3 bilješke mogu biti prikazane na nadzornoj ploči tako što su pričvršćene.',
    ],
    'index'         => [
        'add'           => 'Nova bilješka',
        'description'   => 'Upravljanje bilješkama u :name',
        'header'        => 'Bilješke od :name',
        'title'         => 'Bilješke',
    ],
    'placeholders'  => [
        'name'  => 'Naslov bilješke',
        'type'  => 'Religija, Rasa, Politički sustav',
    ],
    'show'          => [
        'description'   => 'Detaljan pregled bilješke',
        'tabs'          => [
            'description'   => 'Opis',
        ],
        'title'         => 'Bilješka :name',
    ],
];
