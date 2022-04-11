<?php

return [
    'actions'       => [
        'follow'    => 'Seguir',
        'join'      => 'Unirse',
        'unfollow'  => 'Dejar de seguir',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count módulos',
            'roles'     => ':count roles',
            'users'     => ':count usuarios',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Editar',
            'new'       => 'Nuevo tablero',
            'switch'    => 'Cambiar a otro tablero',
        ],
        'boosted'       => 'Las :boosted_campaigns pueden crear tableros personalizados para cada uno de los roles de la campaña.',
        'create'        => [
            'success'   => 'Tablero :name creado.',
            'title'     => 'Nuevo tablero de campaña',
        ],
        'custom'        => [
            'text'  => 'Estás editando el tablero :name de la campaña.',
        ],
        'default'       => [
            'text'  => 'Estás editando el tablero por defecto de la campaña.',
            'title' => 'Tablero por defecto',
        ],
        'delete'        => [
            'success'   => 'Tablero :name eliminado.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copiar widgets',
            'name'          => 'Nombre del tablero',
            'visibility'    => 'Visibilidad',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplica los widgets del tablero :name a este.',
        ],
        'placeholders'  => [
            'name'  => 'Nombre del tablero',
        ],
        'update'        => [
            'success'   => 'Tablero :name actualizado.',
            'title'     => 'Actualizar el tablero de campaña :name',
        ],
        'visibility'    => [
            'default'   => 'Por defecto',
            'none'      => 'Ninguna',
            'visible'   => 'Visible',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Si sigues una campaña, esta aparecerá en el menú de cambio de campaña (arriba a la derecha) bajo tus campañas.',
        'join'      => 'Esta campaña está abierta a nuevos miembros. Haz clic en unirse para enviar una solicitud.',
        'setup'     => 'Configura el tablero de la campaña',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Entendido',
            'title'     => 'Notificación importante',
        ],
    ],
    'recent'        => [
        'title' => ':name recientemente modificados',
    ],
    'settings'      => [
        'title' => 'Ajustes del tablero',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Añadir widget',
            'back_to_dashboard' => 'Volver al tablero',
            'edit'              => 'Editar widget',
        ],
        'title'     => 'Configurar el tablero de campaña',
        'tutorial'  => [
            'blog'  => 'nuestro tutorial',
            'text'  => '¿Necesitas ayuda para configurar el tablero de tu campaña? Lee :blog para obtener ayuda e inspiración.',
        ],
        'widgets'   => [
            'calendar'      => 'Calendario',
            'campaign'      => 'Encabezado de la campaña',
            'header'        => 'Encabezado',
            'preview'       => 'Previsualización de la entidad',
            'random'        => 'Entidad aleatoria',
            'recent'        => 'Reciente',
            'unmentioned'   => 'Entidades sin mención',
        ],
    ],
    'title'         => 'Tablero de',
    'welcome'       => [],
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Opciones avanzadas',
            'delete-confirm'    => 'este widget',
        ],
        'advanced_options_boosted'  => 'Las :boosted_campaigns tienen opciones avanzadas, como mostrar los miembros de una familia o los atributos de una entidad desde el tablero.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Cambiar fecha al día siguiente',
                'previous'  => 'Cambiar fecha al día anterior',
            ],
            'events_today'      => 'Hoy',
            'previous_events'   => 'Anterior',
            'upcoming_events'   => 'Próximo',
        ],
        'campaign'                  => [
            'helper'    => 'Este widget muestra el encabezado de la campaña. Siempre se muestra en el tablero por defecto.',
        ],
        'create'                    => [
            'success'   => 'Widget añadido al tablero.',
        ],
        'delete'                    => [
            'success'   => 'Widget eliminado del tablero.',
        ],
        'fields'                    => [
            'class'             => 'Clase CSS',
            'dashboard'         => 'Tablero',
            'name'              => 'Nombre personalizado del widget',
            'optional-entity'   => 'Link a la entidad',
            'order'             => 'Orden',
            'text'              => 'Texto',
            'width'             => 'Anchura',
        ],
        'helpers'                   => [
            'class' => 'Define una clase CSS personalizada para este widget.',
        ],
        'orders'                    => [
            'name_asc'  => 'Ascendente por nombre',
            'name_desc' => 'Descendiente por nombre',
            'recent'    => 'Recientemente modificadas',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Puedes referenciar el nombre de la entidad aleatoria con {name}',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtro avanzado',
            'advanced_filters'  => [
                'mentionless'   => 'Sin menciones (entidades que no mencionan a otras)',
                'unmentioned'   => 'No mencionada (entidades que no son mencionadas por otras)',
            ],
            'entity-header'     => 'Usar la cabecera de la entidad como imagen',
            'filters'           => 'Filtros',
            'full'              => 'Completa',
            'help'              => 'Solo muestra la previsualización de la última entidad actualizada.',
            'helpers'           => [
                'entity-header'     => 'Si la entidad tiene una imagen de cabecera (funcionalidad de campañas mejoradas), puedes habilitar que este widget use dicha imagen en lugar de la imagen de la entidad.',
                'filters'           => 'Puedes filtrar qué tipo de entidades se muestran. Para saber más sobre este campo, accede a la página de ayuda :link.',
                'full'              => 'Muestra toda la entidad por defecto en lugar de una previsualización.',
                'show_attributes'   => 'Mostrar los atributos bajo la entrada',
                'show_members'      => 'Si la entidad es una familia u organización, muestra sus miembros bajo la entrada.',
                'show_relations'    => 'Muestra las relaciones fijadas bajo la entrada.',
            ],
            'show_attributes'   => 'Mostrar atributos',
            'show_members'      => 'Mostrar miembros',
            'show_relations'    => 'Mostrar relaciones fijadas',
            'singular'          => 'Singular',
            'tags'              => 'Filtra la lista de las entidades recientemente modificadas con etiquetas específicas.',
            'title'             => 'Modificado recientemente',
        ],
        'tabs'                      => [
            'advanced'  => 'Avanzado',
            'setup'     => 'Configuración',
        ],
        'unmentioned'               => [
            'title' => 'Entidades no mencionadas',
        ],
        'update'                    => [
            'success'   => 'Widget modificado.',
        ],
        'widths'                    => [
            '0' => 'Auto',
            '12'=> 'Completa (100%)',
            '3' => 'Cuarto (25%)',
            '4' => 'Tercio (33%)',
            '6' => 'Mitad (50%)',
            '8' => 'Dos tercios (66%)',
            '9' => 'Tres cuartos (75%)',
        ],
    ],
];
