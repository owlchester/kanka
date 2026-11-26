<?php

return [
    'dashboard' => [
        'actions'   => [
            'dismiss'   => 'Entendido, gracias',
            'start'     => 'Hacer un recorrido rápido',
        ],
        'body'      => 'Rediseñamos Kanka para que se sienta más ordenado y despejado, y no te interrumpa mientras creas tus mundos. Algunos botones de navegación cambiaron de lugar, así que preparamos un recorrido rápido para mostrarte dónde están ahora.',
        'steps'     => [
            'campaigns'     => [
                'body_desktop'  => 'Haz clic en el nombre de tu campaña en la parte superior de la barra lateral (o en el ícono del mundo cuando esté contraída) para cambiar de campaña o crear una nueva.',
                'body_mobile'   => 'Abre la pestaña Cuenta en la parte inferior para cambiar entre tus campañas o crear una nueva.',
                'title'         => 'Selector de campañas',
            ],
            'profile'       => [
                'body_desktop'  => 'Tu cuenta, configuración y notificaciones ahora están aquí. Haz clic en tu nombre o avatar para abrir el menú.',
                'body_mobile'   => 'Tu cuenta, configuración y notificaciones están en la pestaña Cuenta, en la parte inferior de la pantalla.',
                'title'         => 'Tu perfil y notificaciones',
            ],
            'search_create' => [
                'body_desktop'              => 'Encuentra cualquier cosa con Buscar (presiona K) o usa el botón + (presiona N) para crear rápidamente una entrada desde cualquier lugar.',
                'body_desktop_search_only'  => 'Encuentra cualquier cosa en esta campaña con Buscar (presiona K).',
                'body_mobile'               => 'Usa Buscar para encontrar cualquier cosa en tu campaña o toca Crear para agregar rápidamente una entrada.',
                'body_mobile_search_only'   => 'Usa Buscar en la parte inferior de la pantalla para encontrar cualquier cosa en esta campaña.',
                'title'                     => 'Búsqueda y creación rápida',
                'title_search_only'         => 'Buscar en tu campaña',
            ],
        ],
        'title'     => 'Te damos la bienvenida a Kanka v4',
        'tour'      => [
            'back'      => 'Atrás',
            'done'      => 'Listo',
            'next'      => 'Siguiente',
            'skip'      => 'Omitir recorrido',
            'step_of'   => 'Paso :current de :total',
        ],
    ],
    'entry_form'=> [
        'actions'   => [
            'dismiss'   => 'No, gracias',
            'try'       => 'Probar',
        ],
        'body'      => 'Creamos una interfaz más ordenada, pensada para escribir, al crear y editar entradas. ¿Quieres probarla? Puedes volver a la anterior cuando quieras desde la configuración de apariencia.',
        'title'     => 'Probar el nuevo diseño del editor de entradas',
    ],
];
