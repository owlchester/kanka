<?php

return [
    'create'        => [
        'title' => 'Nova nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Fixada',
        'note'      => 'Nota superior',
        'notes'     => 'Subnotes',
    ],
    'helpers'       => [
        'nested_without'    => 'S\'estan mostrant les notes sense pare. Feu clic a la fila d\'una nota per a mostrar-ne les descendents.',
    ],
    'hints'         => [
        'is_pinned' => 'Es poden fixar fins a 3 notes al tauler de la campanya.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nom de la nota',
        'note'  => 'Trieu una nota superior',
        'type'  => 'Religió, relat, sistema polític...',
    ],
    'show'          => [],
];
