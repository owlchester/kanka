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
        'name'      => 'Naslov',
        'relation'  => 'Odnos',
        'type'      => 'Tip',
    ],
    'index'         => [
        'add'           => 'Novi dnevnik',
        'description'   => 'Upravljanje dnevnicima u :name.',
        'header'        => 'Dnevnici :name',
        'title'         => 'Dnevnici',
    ],
    'placeholders'  => [
        'author'    => 'Tko je napisao dnevnik',
        'date'      => 'Stvarni datum dnevnika',
        'name'      => 'Naslov dnevnika',
        'type'      => 'Sesija, Jednokratna kampanja, Nacrt',
    ],
    'show'          => [
        'description'   => 'Detaljni pregled dnevnika',
        'title'         => 'Dnevnik :name',
    ],
];
