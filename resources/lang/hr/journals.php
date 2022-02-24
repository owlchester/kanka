<?php

return [
    'create'        => [
        'success'   => 'Kreiran dnevnik ":name".',
        'title'     => 'Novi dnevnik',
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
        'journals'      => 'Prikaži sve ili samo izravnu djecu dnevnike ovog dnevnika.',
        'nested_parent' => 'Prikaz dnevnika od :parent.',
        'nested_without'=> 'Prikazuju se svi dnevnici koji nemaju dnevnik roditelj. Klikni redak da bi vidio/la dnevnike djecu.',
    ],
    'index'         => [
        'add'       => 'Novi dnevnik',
        'header'    => 'Dnevnici :name',
        'title'     => 'Dnevnici',
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
        'tabs'  => [
            'journals'  => 'Dnevnici',
        ],
        'title' => 'Dnevnik :name',
    ],
];
