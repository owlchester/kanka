<?php

return [
    'create'        => [
        'title' => 'Nueva Conversación',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_closed'     => 'Cerrada',
        'messages'      => 'Mensajes',
        'participants'  => 'Participantes',
    ],
    'hints'         => [
        'empty'         => 'No hay participantes en esta conversación.',
        'participants'  => 'Añade participantes a la conversación mediante el icono :icon arriba a la derecha.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Mensaje eliminado.',
        ],
        'is_updated'    => 'Actualizado',
        'load_previous' => 'Cargar mensajes previos',
        'placeholders'  => [
            'message'   => 'Tu mensaje',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'El participante :entity se ha añadido a la conversación.',
        ],
        'destroy'   => [
            'success'   => 'El participante :entity se ha eliminado de la conversación.',
        ],
        'helper'    => 'Agregar y eliminar participantes de :name.',
        'modal'     => 'Participantes',
        'title'     => 'Participantes de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la conversación',
        'type'  => 'Dentro del juego, Preparación, Argumento...',
    ],
    'show'          => [
        'is_closed' => 'La conversación se ha cerrado.',
    ],
    'tabs'          => [
        'participants'  => 'Participantes',
    ],
    'targets'       => [
        'characters'    => 'Personajes',
        'members'       => 'Miembros',
    ],
];
