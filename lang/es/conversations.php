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
    'lists'         => [
        'empty' => 'Registra diálogos, cartas o intercambios entre personajes y facciones.',
    ],
    'messages'      => [
        'actions'           => 'Acciones del mensaje',
        'confirm_delete'    => '¿Eliminar este mensaje?',
        'copied'            => 'Mensaje copiado al portapapeles.',
        'copy_failed'       => 'No se pudo copiar el mensaje al portapapeles.',
        'destroy'           => [
            'success'   => 'Mensaje eliminado.',
        ],
        'editing'           => 'Editando mensaje',
        'empty'             => 'Aún no hay mensajes.',
        'first_message'     => 'Envía un mensaje para iniciar la conversación.',
        'invalid_speaker'   => 'Solo puedes hablar en nombre de un participante autorizado de esta conversación.',
        'is_updated'        => 'Actualizado',
        'keyboard_hint'     => 'Enter para enviar · Shift+Enter para insertar una línea nueva',
        'load_previous'     => 'Cargar mensajes previos',
        'loading'           => 'Cargando mensajes…',
        'no_speaker'        => 'No hay participantes disponibles en cuyo nombre puedas hablar.',
        'placeholders'      => [
            'message'   => 'Tu mensaje',
        ],
        'refresh_failed'    => 'Se envió tu mensaje, pero no se pudo actualizar la conversación.',
        'request_failed'    => 'La solicitud falló. Inténtalo de nuevo.',
        'retry'             => 'Reintentar',
        'saving'            => 'Guardando…',
        'send'              => 'Enviar',
        'sending'           => 'Enviando…',
        'speaking_as'       => 'Hablando como',
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
        'entities'  => 'Entidades',
        'members'   => 'Miembros',
    ],
];
