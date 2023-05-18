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
    'helpers'       => [
        'descendants'       => 'Aquí se muestran todas las familias que descienden de esta, no solo las inmediatamente inferiores.',
        'nested_without'    => 'Mostrando todas las familias sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'hints'         => [
        'members'   => 'Aquí se muestran los miembros de la familia. Se puede añadir un personaje a una familia en el menú de edición de dicho personaje, usando el desplegable "Familia".',
    ],
    'index'         => [],
    'members'       => [
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
