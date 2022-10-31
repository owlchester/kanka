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
        'journal'   => 'Dnevnik roditelj',
        'journals'  => 'Dnevnici djeca',
    ],
    'helpers'       => [
        'journals'          => 'Prikaži sve ili samo izravnu djecu dnevnike ovog dnevnika.',
        'nested_without'    => 'Prikazuju se svi dnevnici koji nemaju dnevnik roditelj. Klikni redak da bi vidio/la dnevnike djecu.',
    ],
    'index'         => [],
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
