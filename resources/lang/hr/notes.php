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
        'note'          => 'Bilješka roditelj',
        'notes'         => 'Bilješka dijete',
        'type'          => 'Tip',
    ],
    'helpers'       => [
        'nested_parent' => 'Prikaz bilješki od :parent.',
        'nested_without'=> 'Prikazuju se sve bilješke koje nemaju bilješku roditelj. Klikni redak da bi vidio/la bilješke djecu.',
    ],
    'hints'         => [
        'is_pinned' => 'Do 3 bilješke mogu biti prikazane na naslovnoj ploči tako što su pričvršćene.',
    ],
    'index'         => [
        'add'           => 'Nova bilješka',
        'description'   => 'Upravljanje bilješkama u :name',
        'header'        => 'Bilješke od :name',
        'title'         => 'Bilješke',
    ],
    'placeholders'  => [
        'name'  => 'Naslov bilješke',
        'note'  => 'Odaberite bilješku roditelja',
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
