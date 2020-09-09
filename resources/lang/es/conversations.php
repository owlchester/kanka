<?php

return [
    'create'        => [
        'description'   => 'Crear nueva conversación',
        'success'       => 'Conversación ":name" creada.',
        'title'         => 'Nueva Conversación',
    ],
    'destroy'       => [
        'success'   => 'Conversación ":name" eliminada.',
    ],
    'edit'          => [
        'description'   => 'Actualizar la conversación',
        'success'       => 'Conversación ":name" actualizada.',
        'title'         => 'Conversación :name',
    ],
    'fields'        => [
        'messages'      => 'Mensajes',
        'name'          => 'Nombre',
        'participants'  => 'Participantes',
        'target'        => 'Objetivo',
        'type'          => 'Tipo',
    ],
    'hints'         => [
        'participants'  => 'Añade participantes a la conversación mediante el icono :icon arriba a la derecha.',
    ],
    'index'         => [
        'add'           => 'Nueva conversación',
        'description'   => 'Gestiona las conversaciones de :name.',
        'header'        => 'Conversaciones de :name',
        'title'         => 'Conversaciones',
    ],
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
        'create'        => [
            'success'   => 'El participante :entity se ha añadido a la conversación.',
        ],
        'description'   => 'Añadir o eliminar participantes de una conversación',
        'destroy'       => [
            'success'   => 'El participante :entity se ha eliminado de la conversación.',
        ],
        'modal'         => 'Participantes',
        'title'         => 'Participantes de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la conversación',
        'type'  => 'Dentro del juego, Preparación, Argumento...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de conversación',
        'title'         => 'Conversación :name',
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
