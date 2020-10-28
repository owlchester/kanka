<?php

return [
    'actions'           => [
        'follow'    => 'Seguir',
        'unfollow'  => 'Dejar de seguir',
    ],
    'campaigns'         => [
        'manage'    => 'Gestionar campaña',
        'tabs'      => [
            'modules'   => ':count módulos',
            'roles'     => ':count roles',
            'users'     => ':count usuarios',
        ],
    ],
    'description'       => 'Tu plaza creativa',
    'helpers'           => [
        'follow'    => 'Si sigues una campaña, esta aparecerá en el menú de cambio de campaña (arriba a la derecha) bajo tus campañas.',
        'setup'     => 'Configura el tablero de la campaña',
    ],
    'latest_release'    => 'Publicación reciente',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Entendido',
            'title'     => 'Notificación importante',
        ],
    ],
    'recent'            => [
        'add'           => 'Crear nuevo :name',
        'no_entries'    => 'Actualmente no hay entradas de este tipo.',
        'title'         => ':name recientemente modificados',
        'view'          => 'Ver todos los :name',
    ],
    'settings'          => [
        'description'   => 'Personaliza lo que ves en tu tablero',
        'edit'          => [
            'success'   => 'Se han guardado tus modificaciones.',
        ],
        'fields'        => [
            'helper'        => 'Puedes cambiar fácilmente lo que ves en tu tablero. Por favor, ten en cuenta que todas tus campañas se verán afectadas, independientemente de los ajustes de estas.',
            'recent_count'  => 'Numero de elementos recientes',
        ],
        'title'         => 'Ajustes del tablero',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Añadir widget',
            'back_to_dashboard' => 'Volver al tablero',
            'edit'              => 'Editar widget',
        ],
        'title'     => 'Configurar el tablero de campaña',
        'widgets'   => [
            'calendar'      => 'Calendario',
            'preview'       => 'Previsualización de la entidad',
            'random'        => 'Entidad aleatoria',
            'recent'        => 'Reciente',
            'unmentioned'   => 'Entidades sin mención',
        ],
    ],
    'title'             => 'Tablero de',
    'welcome'           => [
        'body'  => <<<'TEXT'
¡Bienvenid@ a Kanka! Tu primera campaña ha sido creada y hemos incluido un par de entidades de ejemplo como inspiración (puedes borrarlas cuando quieras).

Seguramente querrás ir empezando a crear algunas entidades propias, así que elige una categoría en el menú de la izquierda y da rienda suelta a tu imaginación. Puedes deshabilitar categorías innecesarias desde la configuración de la campaña: así las esconderás del menú.

Un par de consejos para empezar:
- Puedes escribir @nombreEntidad para enlazar a entidades específicas. El texto del enlace se actualizará automáticamente si renombras o cambias la entidad enlazada.
- Puedes configurar ajustes de tu cuenta como los temas, la cantidad de entidades por página, etc. desde el botón de arriba a la derecha.
- Tenemos una creciente lista de tutoriales en :youtube, que incluyen los atributos y cómo compartir tu campaña con otras personas. Las :faq también te serán útiles.
- Si tienes preguntas, sugerencias o solo quieres charlar, únete a nosotros en :discord
TEXT
,
    ],
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Cambiar fecha al día siguiente',
                'previous'  => 'Cambiar fecha al día anterior',
            ],
            'events_today'      => 'Hoy',
            'previous_events'   => 'Anterior',
            'upcoming_events'   => 'Próximo',
        ],
        'create'        => [
            'success'   => 'Widget añadido al tablero.',
        ],
        'delete'        => [
            'success'   => 'Widget eliminado del tablero.',
        ],
        'fields'        => [
            'width' => 'Anchura',
        ],
        'recent'        => [
            'entity-header' => 'Usar la cabecera de la entidad como imagen',
            'full'          => 'Completa',
            'help'          => 'Solo muestra la previsualización de la última entidad actualizada.',
            'helpers'       => [
                'entity-header' => 'Si la entidad tiene una imagen de cabecera (funcionalidad de campañas mejoradas), puedes habilitar que este widget use dicha imagen en lugar de la imagen de la entidad.',
                'full'          => 'Muestra toda la entidad por defecto en lugar de una previsualización.',
            ],
            'singular'      => 'Singular',
            'tags'          => 'Filtra la lista de las entidades recientemente modificadas con etiquetas específicas.',
            'title'         => 'Modificado recientemente',
        ],
        'unmentioned'   => [
            'title' => 'Entidades no mencionadas',
        ],
        'update'        => [
            'success'   => 'Widget modificado.',
        ],
        'widths'        => [
            '0' => 'Auto',
            '12'=> 'Completa (100%)',
            '3' => 'Cuarto (25%)',
            '4' => 'Tercio (33%)',
            '6' => 'Mitad (50%)',
            '8' => 'Dos tercios (66%)',
        ],
    ],
];
