<?php

return [
    'create'        => [
        'title' => 'Nueva misión',
    ],
    'destroy'       => [],
    'edit'          => [],
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
            'description'       => 'Descripción',
            'entity_or_name'    => 'Selecciona una entidad de la campaña o asigna un nombre a este elemento.',
            'name'              => 'Nombre',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Copiar elementos vinculados a la misión',
        'date'          => 'Fecha',
        'element_role'  => 'Rol',
        'instigator'    => 'Instigador',
        'is_completed'  => 'Completada',
        'location'      => 'Lugar de inicio',
        'role'          => 'Rol',
    ],
    'helpers'       => [
        'is_completed'  => 'Selecciona esto si la misión ya se ha completado.',
    ],
    'hints'         => [
        'quests'    => 'Se puede crear una red de misiones entrelazadas usando el campo Misión Superior.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Fecha real de la misión',
        'entity'    => 'Nombre de un elemento de la misión',
        'location'  => 'Lugar de inicio de la misión',
        'role'      => 'El papel que juega la entidad en la misión',
        'type'      => 'Historia Principal, Arco de Personaje, Misión Secundaria...',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Añadir elemento',
        ],
        'tabs'      => [
            'elements'  => 'Elementos',
        ],
    ],
];
