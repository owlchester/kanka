<?php

return [
    'create'        => [
        'description'   => 'Crear nueva familia',
        'success'       => 'Familia \':name\' creada.',
        'title'         => 'Crear una nueva familia',
    ],
    'destroy'       => [
        'success'   => 'Familia \':name\' borrada.',
    ],
    'edit'          => [
        'success'   => 'Familia \':name\' actualizada.',
        'title'     => 'Editar familia \':name\'',
    ],
    'fields'        => [
        'image'     => 'Imagen',
        'location'  => 'Procedencia',
        'members'   => 'Miembros',
        'name'      => 'Nombre',
        'relation'  => 'Vínculos',
    ],
    'hints'         => [
        'members'   => 'Aquí se enumeran los miembros de una familia. Se puede añadir un personaje a una familia en el menú de edición de dicho personaje, usando el desplegable "Familia".',
    ],
    'index'         => [
        'add'           => 'Nueva Familia',
        'description'   => 'Gestiona las familias de :name.',
        'header'        => 'Familias de :name',
        'title'         => 'Familias',
    ],
    'placeholders'  => [
        'location'  => 'Elegir una procedencia',
        'name'      => 'Nombre de la familia',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la familia',
        'tabs'          => [
            'member'    => 'Miembros',
            'relation'  => 'Vínculos',
        ],
        'title'         => 'Familia :name',
    ],
];
