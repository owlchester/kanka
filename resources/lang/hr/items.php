<?php

return [
    'create'        => [
        'success'   => 'Kreiran predmet ":name".',
        'title'     => 'Novi predmet',
    ],
    'destroy'       => [
        'success'   => 'Uklonjen predmet ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažuriran predmet ":name".',
        'title'     => 'Uredi predmet :name',
    ],
    'fields'        => [
        'character' => 'Lik',
        'image'     => 'Slika',
        'location'  => 'Lokacija',
        'name'      => 'Naziv',
        'price'     => 'Cijena',
        'relation'  => 'Odnos',
        'size'      => 'Veličina',
        'type'      => 'Tip',
    ],
    'index'         => [
        'add'       => 'Novi predmet',
        'header'    => 'Predmeti u :name',
        'title'     => 'Predmeti',
    ],
    'inventories'   => [
        'title' => 'Inventar predmeta :name',
    ],
    'placeholders'  => [
        'character' => 'Izaberi lika',
        'location'  => 'Izaberi lokaciju',
        'name'      => 'Naziv predmeta',
        'price'     => 'Cijena predmeta',
        'size'      => 'Veličina, težina, dimenzije',
        'type'      => 'Oružje, napitak, artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Informacije',
        ],
        'title' => 'Predmet :name',
    ],
];
