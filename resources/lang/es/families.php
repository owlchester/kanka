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
    'families'      => [
        'title' => 'Familias de la familia :name',
    ],
    'fields'        => [
        'families'  => 'Subfamilias',
        'family'    => 'Familia superior',
        'image'     => 'Imagen',
        'location'  => 'Procedencia',
        'members'   => 'Miembros',
        'name'      => 'Nombre',
        'relation'  => 'Relación',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contiene todas las familias que son descendientes de esta familia, no solo las que están directamente bajo ella.',
        'nested'        => 'Con la vista anidada, puedes ver tus familias de forma anidada. Las familias que no tengan familia superior se mostrarán por defecto. A las familias con subfamilias se les puede hacer click para mostrar sus descendientes. Puedes seguir haciendo click hasta que no haya más descendientes que mostrar.',
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
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Esta lista contiene todos los personajes que están en esta familia y en todas las subfamilias.',
            'direct_members'    => 'Muchas familias tienen miembros que las hicieron famosas. Esta lista contiene los personajes que están directamente en esta familia.',
        ],
        'title'     => 'Miembros de la familia :name',
    ],
    'placeholders'  => [
        'location'  => 'Elegir una procedencia',
        'name'      => 'Nombre de la familia',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la familia',
        'tabs'          => [
            'all_members'   => 'Todos los miembros',
            'families'      => 'Familias',
            'member'        => 'Miembros',
            'members'       => 'Miembros',
            'relation'      => 'Relaciones',
        ],
        'title'         => 'Familia :name',
    ],
];
