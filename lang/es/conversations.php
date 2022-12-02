<?php

return [
    'create'        => [
        'title' => 'Nueva Conversación',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Conversación :name',
    ],
    'fields'        => [
        'is_closed'     => 'Cerrada',
        'messages'      => 'Mensajes',
        'participants'  => 'Participantes',
    ],
    'hints'         => [
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
        'conversation'  => 'Conversación',
        'participants'  => 'Participantes',
    ],
    'targets'       => [
        'characters'    => 'Personajes',
        'members'       => 'Miembros',
    ],
];
