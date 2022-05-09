<?php

return [
    'create'        => [
        'success'   => 'Familia ":name" creada.',
        'title'     => 'Nueva familia',
    ],
    'destroy'       => [
        'success'   => 'Familia ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Familia ":name" actualizada.',
        'title'     => 'Editar familia ":name"',
    ],
    'families'      => [
        'title' => 'Familias de la familia :name',
    ],
    'fields'        => [
        'families'  => 'Subfamilias',
        'family'    => 'Familia antecesora',
        'image'     => 'Imagen',
        'location'  => 'Lugar',
        'members'   => 'Miembros',
        'name'      => 'Nombre',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Aquí se muestran todas las familias que descienden de esta, no solo las inmediatamente inferiores.',
        'nested_parent' => 'Mostrando familias de :parent.',
        'nested_without'=> 'Mostrando todas las familias sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'hints'         => [
        'members'   => 'Aquí se muestran los miembros de la familia. Se puede añadir un personaje a una familia en el menú de edición de dicho personaje, usando el desplegable "Familia".',
    ],
    'index'         => [
        'title' => 'Familias',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Aquí se muestran todos los personajes de esta familia y de todas sus subfamilias.',
            'direct_members'    => 'Muchas familias tienen miembros que las hicieron famosas. Aquí se muestran los personajes que están directamente en esta familia.',
        ],
        'title'     => 'Miembros de la familia :name',
    ],
    'placeholders'  => [
        'location'  => 'Elige un lugar',
        'name'      => 'Nombre de la familia',
        'type'      => 'Real, noble, extinguida...',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Todos los miembros',
            'families'      => 'Familias',
            'members'       => 'Miembros',
        ],
    ],
];
