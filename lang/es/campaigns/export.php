<?php

return [
    'actions'   => [
        'download'  => 'Descargar',
        'export'    => 'Exportar los datos de la campaña',
    ],
    'confirm'   => [
        'notification'  => 'Los miembros con el rol de :admin serán notificados cuando la exportación esté lista para descargar.',
        'title'         => 'Confirmación de exportación',
        'warning'       => 'Estás a punto de exportar los datos de la campaña. Este proceso puede llevar mucho tiempo dependiendo del tamaño de la campaña. Puedes seguir utilizando Kanka mientras nuestros servidores generan la exportación.',
    ],
    'errors'    => [
        'limit' => 'La campaña ya se ha exportado una vez hoy. Vuelva a intentarlo mañana.',
    ],
    'expired'   => 'Enlace expirado',
    'helpers'   => [],
    'progress'  => 'Progreso',
    'size'      => 'Tamaño',
    'status'    => [
        'failed'    => 'Fallida',
        'finished'  => 'Terminada',
        'running'   => 'Ejecutándose',
        'scheduled' => 'Programada',
    ],
    'success'   => 'Se está preparando la exportación de la campaña. Recibirás una notificación en Kanka cuando esté lista para descargar.',
    'title'     => 'Exportación de campaña',
];
