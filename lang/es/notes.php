<?php

return [
    'create'        => [
        'title' => 'Nueva nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Subnotas',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas las notas sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'hints'         => [
        'is_pinned' => 'Se pueden fijar hasta 3 notas para que se muestren en el tablero.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Elige una nota superior',
        'type'  => 'Religión, Raza, Sistema politico...',
    ],
    'show'          => [],
];
