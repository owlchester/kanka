<?php

return [
    'create'        => [
        'title' => 'Nueva familia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Miembros',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Esta familia está extinta.',
        'members'       => 'Aquí se muestran los miembros de la familia. Se puede añadir un personaje a una familia en el menú de edición de dicho personaje, usando el desplegable "Familia".',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Añadir miembros',
            'success'   => '{0} No se ha añadido ningún miembro. |{1} Se ha añadido 1 miembro. |[2,*] Se han añadido :count miembros.',
            'title'     => 'Nuevos miembros',
        ],
        'helpers'   => [
            'all_members'       => 'Aquí se muestran todos los personajes de esta familia y de todas sus subfamilias.',
            'direct_members'    => 'Muchas familias tienen miembros que las hicieron famosas. Aquí se muestran los personajes que están directamente en esta familia.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la familia',
        'type'  => 'Real, noble, extinguida...',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Miembros',
            'tree'      => 'Árbol genealógico',
        ],
    ],
];
