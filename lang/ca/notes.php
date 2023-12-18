<?php

return [
    'create'        => [
        'title' => 'Nova nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Subnotes',
    ],
    'helpers'       => [
        'nested_without'    => 'S\'estan mostrant les notes sense pare. Feu clic a la fila d\'una nota per a mostrar-ne les descendents.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Trieu una nota superior',
        'type'  => 'Religió, relat, sistema polític...',
    ],
    'show'          => [],
];
