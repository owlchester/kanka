<?php

return [
    'actions'       => [
        'customise' => 'Personalizar el tablero',
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
        'pitch'         => 'Crea múltiples cuadros de mando con permisos personalizados para cada función de la campaña.',
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
            'new'               => 'Nuevo widget :type',
        ],
        'reorder'   => [
            'helper'    => 'Arrástrame para moverme',
            'success'   => 'Widgets reordenados.',
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
            'welcome'       => 'Bienvenid@',
        ],
    ],
    'title'         => 'Tablero de',
    'welcome'       => [],
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Opciones avanzadas',
        ],
        'advanced_options_boosted'  => 'Habilita más opciones como mostrar pines con una :boosted_campaign.',
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
            'title'     => 'Nuevo widget',
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
            'size'              => 'Tamaño',
            'text'              => 'Texto',
            'width'             => 'Anchura',
        ],
        'helpers'                   => [
            'class'     => 'Define una clase CSS personalizada para este widget.',
            'filters'   => 'Haz clic para conocer las opciones de filtro disponibles.',
        ],
        'orders'                    => [
            'name_asc'  => 'Ascendente por nombre',
            'name_desc' => 'Descendiente por nombre',
            'oldest'    => 'Modificación más antigua',
            'recent'    => 'Recientemente modificadas',
        ],
        'preview'                   => [
            'displays'  => [
                'expand'    => 'Entrada expandible',
                'full'      => 'Entrada completa',
            ],
            'fields'    => [
                'display'   => 'Mostrar',
            ],
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Puedes referenciar el nombre de la entidad aleatoria con {name}',
            ],
            'type'      => [
                'all'   => 'Todos',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtro avanzado',
            'advanced_filters'  => [
                'mentionless'   => 'Sin menciones (entidades que no mencionan a otras)',
                'unmentioned'   => 'No mencionada (entidades que no son mencionadas por otras)',
            ],
            'all-entities'      => 'Todas las entidades',
            'entity-header'     => 'Usar la cabecera de la entidad como imagen',
            'filters'           => 'Filtros',
            'help'              => 'Solo muestra la previsualización de la última entidad actualizada.',
            'helpers'           => [
                'entity-header'     => 'Si la entidad tiene una imagen de cabecera (funcionalidad de campañas mejoradas), puedes habilitar que este widget use dicha imagen en lugar de la imagen de la entidad.',
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
        'welcome'                   => [
            'helper'    => 'Este widget muestra un mensaje de bienvenida en el panel de control que incluye enlaces útiles para los nuevos usuarios de Kanka.',
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
