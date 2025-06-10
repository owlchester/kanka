<?php

return [
    'actions'       => [
        'accept'    => 'Aceptar',
        'reject'    => 'Rechazar',
    ],
    'apply'         => [
        'apply'         => 'Solicitar',
        'help'          => 'Esta campaña está abierta a nuevos miembros. Puedes solicitar unirte a ella mediante este formulario. Te notificaremos cuando los administradores de la campaña revisen tu solicitud.',
        'remove_text'   => 'tu solicitud',
        'success'       => [
            'apply' => 'Tu solicitud se ha guardado. Puedes cambiarla o cancelarla en cualquier momento. Te notificaremos cuando los administradores de la campaña la revisen.',
            'remove'=> 'Se ha eliminado tu solicitud.',
            'update'=> 'Se ha actualizado tu solicitud. Puedes cambiarla o cancelarla en cualquier momento. Te notificaremos cuando los administradores de la campaña la revisen.',
        ],
        'title'         => 'Unirse a :name',
    ],
    'errors'        => [],
    'fields'        => [
        'application'   => 'Solicitud',
        'reason'        => 'Motivo de aprobación / rechazo',
    ],
    'helpers'       => [
        'modal'                 => 'Una campaña que está abierta a solicitudes y al público permite que los usuarios soliciten unirse a la campaña.',
        'no_applications'       => 'Actualmente no hay solicitudes pendientes para unirse a la campaña. Los usuarios pueden solicitar unirse a la campaña visitando su panel de control y haciendo clic en el botón :button.',
        'no_applications_title' => 'No se han encontrado aplicaciones',
        'reason'                => 'Si se proporciona, se notificará al solicitante con este motivo.',
        'role'                  => 'Si se aprueba, el rol al que se añade el aplicante.',
    ],
    'open'          => [
        'closed'    => 'Campaña cerrada',
        'open'      => 'Campaña abierta',
        'title'     => 'Campaña abierta',
    ],
    'placeholders'  => [
        'note'      => 'Escribe tu solicitud para unirte a la campaña',
        'reason'    => 'Tus razones',
    ],
    'public'        => [
        'private'   => 'La campaña es privada.',
        'public'    => 'La campaña es pública.',
        'title'     => 'Campaña pública',
    ],
    'statuses'      => [],
    'toggle'        => [
        'closed'    => 'Cerrada a solicitudes',
        'label'     => 'Estado',
        'open'      => 'Abierta a solicitudes',
        'success'   => 'Actualización del estado de la solicitud para la campaña.',
        'title'     => 'Estado de la solicitud',
    ],
    'update'        => [
        'approve'   => 'Selecciona el rol que se asignará al usuario en tu campaña.',
        'approved'  => 'Solicitud aprobada.',
        'reject'    => 'Escribe un mensaje opcional al usuario explicando el motivo del rechazo.',
        'rejected'  => 'Solicitud rechazada',
    ],
];
