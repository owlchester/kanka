<?php

return [
    'actions'   => [
        'download'  => 'Descargar',
        'export'    => 'Exportar los datos de la campaña',
    ],
    'confirm'   => [
        'notification'  => 'Los miembros con el rol de :admin serán notificados cuando la exportación esté lista para descargar.',
        'title'         => 'Confirmación de exportación',
        'type'          => 'Tipo de exportación',
        'warning'       => 'Estás a punto de exportar los datos de la campaña. Este proceso puede llevar mucho tiempo dependiendo del tamaño de la campaña. Puedes seguir utilizando Kanka mientras nuestros servidores generan la exportación.',
    ],
    'errors'    => [
        'limit'     => 'La campaña ya se ha exportado una vez hoy. Vuelva a intentarlo mañana.',
        'premium'   => 'La exportación en Markdown es una función exclusiva de las campañas premium.',
    ],
    'expired'   => 'Enlace expirado',
    'helpers'   => [
        'json'      => 'Para copias de seguridad y restauración - puede usarse para la importación de campaña.',
        'markdown'  => 'Para compartir y leer - formato legible para personas.',
        'premium'   => 'Disponible solo para campañas premium.',
    ],
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
    'type'      => 'Tipo',
    'types'     => [
        'json'  => 'JSON',
        'md'    => 'Markdown',
    ],
];
