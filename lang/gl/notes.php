<?php

return [
    'create'        => [
        'title' => 'Nova nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Subnotas',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas as notas que non teñen unha nota superior. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Elixe unha nota superior',
        'type'  => 'Relixión, raza, sistema político...',
    ],
    'show'          => [],
];
