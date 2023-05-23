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
    'hints'         => [
        'is_pinned' => 'Es poden fixar fins a 3 notes al tauler de la campanya.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Trieu una nota superior',
        'type'  => 'Religió, relat, sistema polític...',
    ],
    'show'          => [],
];
