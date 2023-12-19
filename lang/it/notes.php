<?php

return [
    'create'        => [
        'title' => 'Nuova Nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Sottonote',
    ],
    'helpers'       => [
        'nested_without'    => 'Visualizzazione delle note che non hanno una nota sovraordinata. Clicca su una fila per vedere le sottonote.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Scegli una nota sovraordinata',
        'type'  => 'Religione, Razza, Systema Politico',
    ],
    'show'          => [],
];
