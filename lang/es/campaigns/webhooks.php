<?php

return [
    'actions'       => [
        'action'    => 'Cambiar estado',
        'add'       => 'Crear webhook',
        'bulks'     => [
            'delete_success'    => '{1} Se ha eliminado :count webhook.|[2,*] Se han eliminado :count webhooks.',
            'disable'           => 'Desactivar',
            'disable_success'   => '{1} Se ha desactivado :count webhook.|[2,*] Se han desactivado :count webhooks.',
            'enable'            => 'Activar',
            'enable_success'    => '{1} Se ha activado :count webhook.|[2,*] Se han activado :count webhooks.',
        ],
        'test'      => 'Webhook de prueba',
        'update'    => 'Actualizar webhook',
    ],
    'create'        => [
        'success'   => 'El webhook se ha creado con éxito',
        'title'     => 'Añadir nuevo webhook',
    ],
    'destroy'       => [
        'success'   => 'Webhook eliminado correctamente.',
    ],
    'edit'          => [
        'success'   => 'Webhook actualizado correctamente',
        'title'     => 'Actualizar webhook',
    ],
    'fields'        => [
        'enabled'           => 'Habilitado',
        'event'             => 'Evento',
        'events'            => [
            'deleted'   => 'Entidad eliminada',
            'edited'    => 'Entidad editada',
            'new'       => 'Entidad nueva',
        ],
        'message'           => 'Mensaje',
        'private_entities'  => [
            'helper'    => 'No activar el webhook al actualizar entidades privadas.',
            'skip'      => 'Omitir entidades privadas',
        ],
        'type'              => 'Tipo',
        'types'             => [
            'custom'    => 'Mensaje',
            'payload'   => 'Payload',
        ],
        'url'               => 'Url',
    ],
    'helper'        => [
        'active'    => 'Si el webhook está activo',
        'message'   => 'Añade un mensaje personalizado con soporte para asignaciones',
        'status'    => 'Cambiar el estado activo del webhook',
    ],
    'pitch'         => 'Crea webhooks personalizados para recibir actualizaciones personalizadas cada vez que se actualice una entidad de la campaña.',
    'placeholders'  => [
        'message'   => '{who} ha hecho cambios en {name}, revísalos en {url}.',
        'url'       => 'URL del webhook',
    ],
    'test'          => [
        'success'   => 'Solicitud de prueba enviada',
    ],
    'title'         => 'Webhooks',
    'toggle'        => [
        'disable'   => 'Webhook deshabilitado correctamente.',
        'enable'    => 'Webhook habilitado correctamente.',
    ],
];
