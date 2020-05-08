<?php

return [
    'create'        => [
        'description'   => 'Kreiraj novi predmet',
        'success'       => 'Kreiran predmet ":name".',
        'title'         => 'Novi predmet',
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
        'add'           => 'Novi predmet',
        'description'   => 'Upravljanje predmetima u :name.',
        'header'        => 'Predmeti u :name',
        'title'         => 'Predmeti',
    ],
    'inventories'   => [
        'description'   => 'Inventar entiteta u kojem se predmet nalazi.',
        'title'         => 'Inventar predmeta :name',
    ],
    'placeholders'  => [
        'character' => 'Izaberi lika',
        'location'  => 'Izaberi lokaciju',
        'name'      => 'Naziv predmeta',
        'price'     => 'Cijena predmeta',
        'size'      => 'Veličina, težina, dimenzije',
        'type'      => 'Oružje, napitak, artefakt',
    ],
    'quests'        => [
        'description'   => 'Zadaci kojih je predmet dio.',
        'title'         => 'Zadaci predmeta :name',
    ],
    'show'          => [
        'description'   => 'Detaljan pregled predmeta',
        'tabs'          => [
            'information'   => 'Informacija',
            'inventories'   => 'Informacije',
            'quests'        => 'Zadaci',
        ],
        'title'         => 'Predmet :name',
    ],
];
