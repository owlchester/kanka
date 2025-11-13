<?php

return [
    'create'        => [
        'title' => 'Nueva familia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Esta familia está extinta.',
        'members'       => 'Aquí se muestran los miembros de la familia. Se puede añadir un personaje a una familia en el menú de edición de dicho personaje, usando el desplegable "Familia".',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'helper'    => 'Añadir uno o mas miembros a :name.',
            'success'   => '{0} No se ha añadido ningún miembro. |{1} Se ha añadido 1 miembro. |[2,*] Se han añadido :count miembros.',
            'title'     => 'Nuevos miembros',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la familia',
        'type'  => 'Real, noble, extinguida...',
    ],
    'show'          => [
        'tabs'  => [
            'tree'  => 'Árbol genealógico',
        ],
    ],
];
