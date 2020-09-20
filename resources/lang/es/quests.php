<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Añadir personaje a la misión',
            'success'       => 'Personaje añadido a :name.',
            'title'         => 'Nuevo personaje para :name',
        ],
        'destroy'   => [
            'success'   => 'Personaje eliminado de la misión :name.',
        ],
        'edit'      => [
            'description'   => 'Actualizar personaje de la misión',
            'success'       => 'Personaje de la misión :name actualizado.',
            'title'         => 'Actualizar personaje de :name',
        ],
        'fields'    => [
            'character'     => 'Personaje',
            'description'   => 'Descripción',
        ],
        'title'     => 'Personajes en :name',
    ],
    'create'        => [
        'description'   => 'Crear nueva misión',
        'success'       => 'Misión ":name" creada.',
        'title'         => 'Nueva misión',
    ],
    'destroy'       => [
        'success'   => 'Misión ":name" eliminada.',
    ],
    'edit'          => [
        'description'   => 'Editar misión',
        'success'       => 'Misión ":name" actualizada.',
        'title'         => 'Editar misión :name',
    ],
    'fields'        => [
        'character'     => 'Instigador',
        'characters'    => 'Personajes',
        'copy_elements' => 'Copiar elementos vinculados a la misión',
        'date'          => 'Fecha',
        'description'   => 'Descripción',
        'image'         => 'Imagen',
        'is_completed'  => 'Completada',
        'items'         => 'Objetos',
        'locations'     => 'Lugares',
        'name'          => 'Nombre',
        'organisations' => 'Organizaciones',
        'quest'         => 'Misión superior',
        'quests'        => 'Submisiones',
        'role'          => 'Rol',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Con la vista anidada, puedes ver tus misiones de forma anidada. Las misiones que no tengan misión superior se mostrarán por defecto. A las misiones con submisiones se les puede hacer click para mostrar sus descendientes. Puedes seguir haciendo click hasta que no haya más descendientes que mostrar.',
    ],
    'hints'         => [
        'quests'    => 'Se puede crear una red de misiones entrelazadas usando el campo Misión Superior.',
    ],
    'index'         => [
        'add'           => 'Nueva misión',
        'description'   => 'Gestiona las misiones de :name.',
        'header'        => 'Misiones de :name',
        'title'         => 'Misiones',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Añadir objeto a la misión',
            'success'       => 'Objeto añadido a :name.',
            'title'         => 'Nuevo objeto en :name',
        ],
        'destroy'   => [
            'success'   => 'Objeto eliminado de :name.',
        ],
        'edit'      => [
            'description'   => 'Actualizar objeto de misión',
            'success'       => 'Objeto de :name actualizado.',
            'title'         => 'Actualizar objeto de :name',
        ],
        'fields'    => [
            'description'   => 'Descripción',
            'item'          => 'Objeto',
        ],
        'title'     => 'Objetos de :name',
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
        'title'     => 'Lugares en :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Añadir una organización a la misión',
            'success'       => 'Organización añadida a :name.',
            'title'         => 'Nueva organización para :name',
        ],
        'destroy'   => [
            'success'   => 'Organización de :name eliminada de la misión.',
        ],
        'edit'      => [
            'description'   => 'Actualizar organización de la misión',
            'success'       => 'Organización de :name actualizada.',
            'title'         => 'Actualizar organización de :name',
        ],
        'fields'    => [
            'description'   => 'Descripción',
            'organisation'  => 'Organización',
        ],
        'title'     => 'Organizaciones en :name',
    ],
    'placeholders'  => [
        'date'  => 'Fecha real de la misión',
        'name'  => 'Nombre de la misión',
        'quest' => 'Misión superior',
        'role'  => 'El papel que juega la entidad en la misión',
        'type'  => 'Historia Principal, Arco de Personaje, Misión Secundaria...',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Añadir personaje',
            'add_item'          => 'Añadir objeto',
            'add_location'      => 'Añadir localización',
            'add_organisation'  => 'Añadir organización',
        ],
        'description'   => 'Vista detallada de la misión',
        'tabs'          => [
            'characters'    => 'Personajes',
            'information'   => 'Información',
            'items'         => 'Objetos',
            'locations'     => 'Lugares',
            'organisations' => 'Organizaciones',
            'quests'        => 'Misiones',
        ],
        'title'         => 'Misión :name',
    ],
];
