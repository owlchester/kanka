<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Poner personaje en una misión',
            'success'       => 'Personaje añadido a :name.',
            'title'         => 'Nuevo personaje para :name',
        ],
        'destroy'   => [
            'success'   => 'Personaje de misión para :name eliminado.',
        ],
        'edit'      => [
            'description'   => 'Actualizar personaje de la misión',
            'success'       => 'Personaje de misión para :name actualizado.',
            'title'         => 'Actualizar personaje para :name',
        ],
        'fields'    => [
            'character'     => 'Personaje',
            'description'   => 'Descripción',
        ],
    ],
    'create'        => [
        'description'   => 'Crear nueva misión',
        'success'       => 'Misión \':name\' creada.',
        'title'         => 'Nueva Misión',
    ],
    'destroy'       => [
        'success'   => 'Misión \':name\' borrada.',
    ],
    'edit'          => [
        'description'   => 'Editar misión',
        'success'       => 'Misión \':name\' actualizada.',
        'title'         => 'Editar misión :name',
    ],
    'fields'        => [
        'character'     => 'Instigador',
        'characters'    => 'Personajes',
        'description'   => 'Descripción',
        'image'         => 'Imagen',
        'is_completed'  => 'Completada',
        'locations'     => 'Localizaciones',
        'name'          => 'Nombre',
        'quest'         => 'Misión superior',
        'type'          => 'Tipo',
    ],
    'hints'         => [
        'quests'    => 'Se puede crear una red de misiones entrelazadas usando el campo Misión Superior.',
    ],
    'index'         => [
        'add'           => 'Nueva Misión',
        'description'   => 'Gestiona las misiones de :name.',
        'header'        => 'Misiones de :name',
        'title'         => 'Misiones',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Seleccionar una localización para la misión',
            'success'       => 'Localización añadida a :name.',
            'title'         => 'Nueva localización para :name',
        ],
        'destroy'   => [
            'success'   => 'Localización de la misión :name eliminada.',
        ],
        'edit'      => [
            'description'   => 'Actualizar la localización de una misión',
            'success'       => 'Localización de la misión :name actualizada.',
            'title'         => 'Actualizar localización para :name',
        ],
        'fields'    => [
            'description'   => 'Descripción',
            'location'      => 'Localización',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la misión',
        'quest' => 'Misión superior',
        'type'  => 'Historia Principal, Arco de Personaje, Misión Secundaria...',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Añadir personaje',
            'add_location'  => 'Añadir localización',
        ],
        'description'   => 'Vista detallada de la misión',
        'tabs'          => [
            'characters'    => 'Personajes',
            'information'   => 'Información',
            'locations'     => 'Localización',
            'quests'        => 'Misiones',
        ],
        'title'         => 'Misión :name',
    ],
];
