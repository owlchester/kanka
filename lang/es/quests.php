<?php

return [
    'create'        => [
        'title' => 'Nueva misión',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'        => [
            'success'   => 'Se ha añadido la entidad :entity a la misión.',
            'title'     => 'Nuevo elemento para :name',
        ],
        'destroy'       => [
            'success'   => 'Se ha quitado :entidad de la misión.',
        ],
        'edit'          => [
            'success'   => 'Se ha actualizado :entity en la misión.',
            'title'     => 'Actualizar elemento de la misión :name',
        ],
        'fields'        => [
            'copy_entity_entry' => 'Usar descripción de entrada',
            'entity_or_name'    => 'Selecciona una entidad de la campaña o asigna un nombre a este elemento.',
        ],
        'helpers'       => [
            'copy_entity_entry' => 'Muestra la descripción de la entrada vinculada en lugar de la descripción personalizada.',
        ],
        'placeholders'  => [
            'name'  => 'Nombre del elemento',
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
        'status'        => 'Estado',
    ],
    'helpers'       => [
        'is_completed'  => 'Selecciona esto si la misión ya se ha completado.',
        'status'        => 'El estado actual de la misión.',
    ],
    'hints'         => [
        'is_abandoned'  => 'Esta misión ha sido abandonada.',
        'is_completed'  => 'Esta misión está completada.',
        'is_ongoing'    => 'Esta misión está en curso.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Crea misiones para registrar objetivos, tramas o motivaciones de los personajes.',
    ],
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
    'status'        => [
        'abandoned'     => 'Abandonada',
        'completed'     => 'Completada',
        'not_started'   => 'No iniciada',
        'ongoing'       => 'En curso',
    ],
];
