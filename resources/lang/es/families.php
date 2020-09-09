<?php

return [
    'create'        => [
        'description'   => 'Crear nueva familia',
        'success'       => 'Familia ":name" creada.',
        'title'         => 'Nueva familia',
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
        'relation'  => 'Relación',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Aquí se muestran todas las familias que descienden de esta, no solo las inmediatamente inferiores.',
        'nested'        => 'Con la vista anidada, puedes ver tus familias de forma anidada. Las familias que no tengan familia antecesora se mostrarán por defecto. A las familias con subfamilias se les puede hacer click para mostrar sus descendientes. Puedes seguir haciendo click hasta que no haya más descendientes que mostrar.',
    ],
    'hints'         => [
        'members'   => 'Aquí se muestran los miembros de la familia. Se puede añadir un personaje a una familia en el menú de edición de dicho personaje, usando el desplegable "Familia".',
    ],
    'index'         => [
        'add'           => 'Nueva familia',
        'description'   => 'Gestiona las familias de :name.',
        'header'        => 'Familias de :name',
        'title'         => 'Familias',
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
        'description'   => 'Vista detallada de la familia',
        'tabs'          => [
            'all_members'   => 'Todos los miembros',
            'families'      => 'Familias',
            'members'       => 'Miembros',
            'relation'      => 'Relaciones',
        ],
        'title'         => 'Familia :name',
    ],
];
