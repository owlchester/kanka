<?php

return [
    '403'               => [
        'body'  => '¡Parece que no tienes permiso para acceder a esta página!',
        'title' => 'Permiso denegado',
    ],
    '403-form'          => [
        'help'  => 'Puede que tu sesión haya caducado. Intenta volver a iniciar sesión en otra ventana antes de guardar.',
    ],
    '404'               => [
        'body'  => 'Lo sentimos, la página que estás buscando no se encuentra.',
        'title' => 'Página no encontrada',
    ],
    '500'               => [
        'body'  => [
            '1' => 'Ups, parece que algo ha ido mal.',
            '2' => 'Nos ha llegado un informe con este error, pero a veces nos ayuda saber un poco más sobre lo que estabas haciendo.',
        ],
        'title' => 'Error',
    ],
    '503'               => [
        'body'  => [
            '1' => 'Kanka está en mantenimiento ahora mismo. ¡Suele ser porque hay una actualización en camino!',
            '2' => 'Disculpa las molestias. Todo volverá a la normalidad en solo unos minutos.',
        ],
        'json'  => 'Kanka está actualmente en mantenimiento, por favor inténtalo de nuevo en unos minutos.',
        'title' => 'Mantenimiento',
    ],
    '503-form'          => [],
    'back-to-campaigns' => 'Volver a una de tus campañas',
    'entity-visibility' => [
        'comparison'    => 'Configuración del permiso para ver por rol de campaña',
        'direct'        => 'Permiso para ver asignado directamente a :member: :setting',
        'entity-view'   => 'Ver esta entrada',
        'membership'    => 'Rol de :member',
        'module-view'   => 'Ver en :module',
        'reasons'       => [
            'direct-deny'   => 'Se le denegó explícitamente a :member el permiso para ver esta entrada.',
            'no-grant'      => ':member no tiene ningún permiso para ver este módulo o esta entrada.',
            'private'       => 'Esta entrada es privada. Solo los administradores pueden verla. La configuración de abajo no anula la privacidad.',
            'role-deny'     => 'Los siguientes roles deniegan el permiso para ver esta entrada:',
        ],
        'role'          => 'Rol',
        'settings'      => [
            'allow'         => 'Permitir',
            'assigned'      => 'Asignado',
            'automatic'     => 'Automático (administrador)',
            'deny'          => 'Denegar',
            'fallback'      => 'Aplicado de forma predeterminada',
            'granted'       => 'Concedido',
            'inherit'       => 'Heredar',
            'not-granted'   => 'No concedido',
            'unassigned'    => 'Sin asignar',
        ],
        'title'         => '¿Por qué :member no puede ver esta entrada?',
    ],
    'footer'            => 'Si necesitas más asistencia, contáctanos en hello@kanka.io o en :discord',
    'log-in'            => 'Acceder a tu cuenta podría revelarte lo que estás buscando.',
    'post_layout'       => 'Diseño de post no válido.',
    'private-campaign'  => [
        'auth'  => [
            'helper'    => 'No tienes acceso a esta campaña.',
        ],
        'guest' => [
            'helper'    => 'La campaña a la que intentas acceder es privada y no has iniciado sesión.',
            'login'     => 'Iniciar sesión podría permitirte acceder a los contenidos.',
        ],
        'title' => 'Campaña privada',
    ],
];
