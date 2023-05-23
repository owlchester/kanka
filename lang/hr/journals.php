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
    ],
    'helpers'       => [
        'journals'          => 'Prikaži sve ili samo izravnu djecu dnevnike ovog dnevnika.',
        'nested_without'    => 'Prikazuju se svi dnevnici koji nemaju dnevnik roditelj. Klikni redak da bi vidio/la dnevnike djecu.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Tko je napisao dnevnik',
        'date'      => 'Stvarni datum dnevnika',
        'type'      => 'Sesija, Jednokratna kampanja, Nacrt',
    ],
    'show'          => [],
];
