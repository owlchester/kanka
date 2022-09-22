<?php

return [
    'create'        => [
        'title' => 'Novi dnevnik',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Datum',
        'image'     => 'Slika',
        'journal'   => 'Dnevnik roditelj',
        'journals'  => 'Dnevnici djeca',
        'name'      => 'Naslov',
        'type'      => 'Tip',
    ],
    'helpers'       => [
        'journals'          => 'Prikaži sve ili samo izravnu djecu dnevnike ovog dnevnika.',
        'nested_without'    => 'Prikazuju se svi dnevnici koji nemaju dnevnik roditelj. Klikni redak da bi vidio/la dnevnike djecu.',
    ],
    'index'         => [
        'title' => 'Dnevnici',
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
    ],
];
