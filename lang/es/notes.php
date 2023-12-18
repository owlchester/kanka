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
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Elige una nota superior',
        'type'  => 'Religión, Raza, Sistema politico...',
    ],
    'show'          => [],
];
