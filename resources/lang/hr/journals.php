<?php

return [
    'create'        => [
        'description'   => 'Kreiraj novi dnevnik',
        'success'       => 'Kreiran dnevnik ":name".',
        'title'         => 'Novi dnevnik',
    ],
    'destroy'       => [
        'success'   => 'Uklonjen dnevnik ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažuriran dnevnik ":name".',
        'title'     => 'Uredi dnevnik :name',
    ],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Datum',
        'image'     => 'Slika',
        'journal'   => 'Dnevnik roditelj',
        'journals'  => 'Dnevnici djeca',
        'name'      => 'Naslov',
        'relation'  => 'Odnos',
        'type'      => 'Tip',
    ],
    'helpers'       => [
        'journals'  => 'Prikaži sve ili samo izravnu djecu dnevnike ovog dnevnika.',
        'nested'    => 'Prvo se prikazuju dnevnici bez dnevnika roditelja. Klikni na redak za istraživanje djece dnevnike ovog dnevnika.',
    ],
    'index'         => [
        'add'           => 'Novi dnevnik',
        'description'   => 'Upravljanje dnevnicima u :name.',
        'header'        => 'Dnevnici :name',
        'title'         => 'Dnevnici',
    ],
    'journals'      => [
        'title' => 'Djeca dnevnici dnevnika :name',
    ],
    'placeholders'  => [
        'author'    => 'Tko je napisao dnevnik',
        'date'      => 'Stvarni datum dnevnika',
        'journal'   => 'Odaberi dnevnika roditelja',
        'name'      => 'Naslov dnevnika',
        'type'      => 'Sesija, Jednokratna kampanja, Nacrt',
    ],
    'show'          => [
        'description'   => 'Detaljni pregled dnevnika',
        'tabs'          => [
            'journals'  => 'Dnevnici',
        ],
        'title'         => 'Dnevnik :name',
    ],
];
