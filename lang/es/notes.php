<?php

return [
    'create'        => [
        'title' => 'Nueva nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Fijada',
        'note'      => 'Nota superior',
        'notes'     => 'Subnotas',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas las notas sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'hints'         => [
        'is_pinned' => 'Se pueden fijar hasta 3 notas para que se muestren en el tablero.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nombre de la nota',
        'note'  => 'Elige una nota superior',
        'type'  => 'Religión, Raza, Sistema politico...',
    ],
    'show'          => [],
];
