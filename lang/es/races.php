<?php

return [
    'characters'    => [],
    'create'        => [
        'title' => 'Nueva raza',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'members'   => 'Miembros',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Esta raza está extinta.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'helper'    => 'Agrega uno o varios personajes a :name.',
            'submit'    => 'Añadir miembros',
            'success'   => '{0} No se ha añadido ningún miembro. |{1} Se ha añadido 1 miembro. |[2,*] :se han añadido un número de miembros.',
            'title'     => 'Nuevos miembros',
        ],
    ],
    'placeholders'  => [
        'type'  => 'Humano, Elfo, Troll...',
    ],
    'races'         => [],
    'show'          => [],
];
