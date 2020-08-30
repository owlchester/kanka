<?php

return [
    '403'       => [
        'body'  => '¡Parece que no tienes permiso para acceder a esta página!',
        'title' => 'Permiso denegado',
    ],
    '403-form'  => [
        'help'  => 'Puede que tu sesión haya caducado. Intenta volver a iniciar sesión en otra ventana antes de guardar.',
    ],
    '404'       => [
        'body'  => 'Lo sentimos, la página que estás buscando no se encuentra.',
        'title' => 'Página no encontrada',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Ups, parece que algo ha ido mal.',
            '2' => 'Nos ha llegado un informe con este error, pero a veces nos ayuda saber un poco más sobre lo que estabas haciendo.',
        ],
        'title' => 'Error',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka está en mantenimiento ahora mismo. ¡Suele ser porque hay una actualización en camino!',
            '2' => 'Disculpa las molestias. Todo volverá a la normalidad en solo unos minutos.',
        ],
        'title' => 'Mantenimiento',
    ],
    '503-form'  => [
        'body'  => 'No hemos podido guardar tus datos por alguna de las siguientes razones. Por favor, abre Kanka en un :link. Si la app está en mantenimiento, guarda tus datos en algún otro sitio hasta que la app vuelva a estar en funcionamiento y vuelve a intentarlo. En cambio, si te sale un mensaje diciendo "Checking your browser", puedes intentar retroceder y volver a darle a Guardar.',
        'link'  => 'Nueva ventana',
        'title' => 'Ha ocurrido algo inesperado.',
    ],
    'footer'    => 'Si necesitas más asistencia, contáctanos en hello@kanka.io o en :discord',
];
