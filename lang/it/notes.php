<?php

return [
    'create'        => [
        'title' => 'Nuova Nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Fissata',
        'note'      => 'Nota sovraordinata',
        'notes'     => 'Sottonote',
    ],
    'helpers'       => [
        'nested_without'    => 'Visualizzazione delle note che non hanno una nota sovraordinata. Clicca su una fila per vedere le sottonote.',
    ],
    'hints'         => [
        'is_pinned' => 'Fino a 3 note possono essere fissate per essere visualizzate nella dashboard.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nome della nota',
        'note'  => 'Scegli una nota sovraordinata',
        'type'  => 'Religione, Razza, Systema Politico',
    ],
    'show'          => [],
];
