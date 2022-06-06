<?php

return [
    'create'        => [
        'title' => 'Nova nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'description'   => 'Descripció',
        'image'         => 'Imatge',
        'is_pinned'     => 'Fixada',
        'name'          => 'Nom',
        'note'          => 'Nota superior',
        'notes'         => 'Subnotes',
        'type'          => 'Tipus',
    ],
    'helpers'       => [
        'nested_parent' => 'S\'estan mostrant les notes de :parent.',
        'nested_without'=> 'S\'estan mostrant les notes sense pare. Feu clic a la fila d\'una nota per a mostrar-ne les descendents.',
    ],
    'hints'         => [
        'is_pinned' => 'Es poden fixar fins a 3 notes al tauler de la campanya.',
    ],
    'index'         => [
        'title' => 'Notes',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la nota',
        'note'  => 'Trieu una nota superior',
        'type'  => 'Religió, relat, sistema polític...',
    ],
    'show'          => [],
];
