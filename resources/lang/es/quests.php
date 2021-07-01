<?php

return [
    'characters'    => [],
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
    'elements'      => [
        'create'    => [
            'success'   => 'Se ha añadido la entidad :entity a la misión.',
            'title'     => 'Nuevo elemento para :name',
        ],
        'destroy'   => [
            'success'   => 'Se ha quitado :entidad de la misión.',
        ],
        'edit'      => [
            'success'   => 'Se ha actualizado :entity en la misión.',
            'title'     => 'Actualizar elemento de la misión :name',
        ],
        'fields'    => [
            'description'   => 'Descripción',
            'quest'         => 'Misión',
        ],
        'title'     => 'Elementos de la misión :name',
    ],
    'fields'        => [
        'character'     => 'Instigador',
        'copy_elements' => 'Copiar elementos vinculados a la misión',
        'date'          => 'Fecha',
        'description'   => 'Descripción',
        'image'         => 'Imagen',
        'is_completed'  => 'Completada',
        'name'          => 'Nombre',
        'quest'         => 'Misión superior',
        'quests'        => 'Submisiones',
        'role'          => 'Rol',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando las misiones de :parent.',
        'nested_without'=> 'Mostrando todas las misiones sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
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
    'items'         => [],
    'locations'     => [],
    'organisations' => [],
    'placeholders'  => [
        'date'  => 'Fecha real de la misión',
        'name'  => 'Nombre de la misión',
        'quest' => 'Misión superior',
        'role'  => 'El papel que juega la entidad en la misión',
        'type'  => 'Historia Principal, Arco de Personaje, Misión Secundaria...',
    ],
    'show'          => [
        'actions'       => [
            'add_element'   => 'Añadir elemento',
        ],
        'description'   => 'Vista detallada de la misión',
        'tabs'          => [
            'elements'      => 'Elementos',
            'information'   => 'Información',
            'quests'        => 'Misiones',
        ],
        'title'         => 'Misión :name',
    ],
];
