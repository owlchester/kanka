<?php

return [
    'create'        => [
        'title' => 'Nuovo Diario',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Autore',
        'date'      => 'Data',
    ],
    'helpers'       => [
        'journals'          => 'Visualizza tutti o solo i diari secondari di questa diario.',
        'nested_without'    => 'Visualizzazione di tutti i diari che non hanno un diario genitore. Fai clic su una riga per visualizzare i diari figli.',
    ],
    'index'         => [],
    'placeholders'  => [
        'author'    => 'Chi ha scritto il diario',
        'date'      => 'Data del diario',
        'type'      => 'Sessione, One Shot, Bozza',
    ],
    'show'          => [],
];
