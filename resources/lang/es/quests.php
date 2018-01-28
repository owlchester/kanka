<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Poner personaje en una Misión',
            'success'       => 'Personaje añadido a :name.',
            'title'         => 'Nuevo Personaje para :name',
        ],
        'destroy'   => [
            'success'   => 'Personaje de misión para :name eliminado.',
        ],
        'edit'      => [
            'success'   => 'Personaje de misión para :name actualizado.',
            'title'     => 'Actualizar personaje para :name',
        ],
        'fields'    => [
            'character'     => 'Personaje',
            'description'   => 'Descripción',
        ],
    ],
    'create'        => [
        'success'   => 'Misión \':name\' creada.',
        'title'     => 'Crear nueva misión',
    ],
    'destroy'       => [
        'success'   => 'Misión \':name\' borrada.',
    ],
    'edit'          => [
        'success'   => 'Misión \':name\' actualizada.',
        'title'     => 'Editar Misión :name',
    ],
    'fields'        => [
        'characters'    => 'Personajes',
        'description'   => 'Descripción',
        'image'         => 'Imagen',
        'locations'     => 'Localización',
        'name'          => 'Nombre',
        'type'          => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nueva Misión',
        'description'   => 'Gestionar las misiones de :name.',
        'header'        => 'Misiones de :name',
        'title'         => 'Misiones',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Seleccionar una localización para la Misión',
            'success'       => 'Localización añadida a :name.',
            'title'         => 'Nueva Localización para :name',
        ],
        'destroy'   => [
            'success'   => 'Localización de la misión :name eliminada.',
        ],
        'edit'      => [
            'success'   => 'Localización de la misión :name actualizada.',
            'title'     => 'Actualizar localizacion para :name',
        ],
        'fields'    => [
            'description'   => 'Descripción',
            'location'      => 'Localización',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la misión',
        'type'  => 'Historia Principal, Arco de Personaje, Misión Secundaria...',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Añadir un personaje',
            'add_location'  => 'Añadir una localización',
        ],
        'description'   => 'Vista detallada de la misión',
        'tabs'          => [
            'characters'    => 'Personajes',
            'information'   => 'Información',
            'locations'     => 'Localización',
        ],
        'title'         => 'Misión :name',
    ],
];
