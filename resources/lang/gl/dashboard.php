<?php

return [
    'actions'           => [
        'follow'    => 'Seguir',
        'join'      => 'Unirse',
        'unfollow'  => 'Deixar de seguir',
    ],
    'campaigns'         => [
        'tabs'  => [
            'modules'   => ':count módulos',
            'roles'     => ':count roles',
            'users'     => ':count integrantes',
        ],
    ],
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Editar',
            'new'       => 'Novo taboleiro',
            'switch'    => 'Cambiar a outro taboleiro',
        ],
        'boosted'       => 'As :boosted_campaigns poden crear taboleiros personalizados para cada un dos roles da campaña.',
        'create'        => [
            'success'   => 'Taboleiro ":name" creado.',
            'title'     => 'Novo taboleiro de campaña',
        ],
        'custom'        => [
            'text'  => 'Estás editando o taboleiro ":name" da campaña.',
        ],
        'default'       => [
            'text'  => 'Estás editando o taboleiro por defecto da campaña.',
            'title' => 'Taboleiro por defecto',
        ],
        'delete'        => [
            'success'   => 'Taboleiro ":name" eliminado.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copiar complementos',
            'name'          => 'Nome do taboleiro',
            'visibility'    => 'Visibilidade',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Copia os complementos do taboleiro ":name" neste novo taboleiro.',
        ],
        'placeholders'  => [
            'name'  => 'Nome do taboleiro',
        ],
        'update'        => [
            'success'   => 'Taboleiro ":name" actualizado.',
            'title'     => 'Actualizar taboleiro ":name"',
        ],
        'visibility'    => [
            'default'   => 'Por defecto',
            'none'      => 'Non',
            'visible'   => 'Visíbel',
        ],
    ],
    'description'       => 'O lar da túa creatividade',
    'helpers'           => [
        'follow'    => 'Seguir unha campaña fará que esta apareza no selector de campañas (arriba á esquerda) baixo as túas campañas.',
        'join'      => 'Esta campaña está aberta a inscricións. Fai clic para solicitar unirte a ela.',
        'setup'     => 'Configura os taboleiros da túa campaña.',
    ],
    'latest_release'    => 'Última versión',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'De acordo',
            'title'     => 'Notificación importante',
        ],
    ],
    'recent'            => [
        'title' => ':name modificacións recentes',
    ],
    'settings'          => [
        'title' => 'Configuración do taboleiro',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Engadir complemento',
            'back_to_dashboard' => 'Voltar ao taboleiro',
            'edit'              => 'Editar complemento',
        ],
        'title'     => 'Configuración do taboleiro de campaña',
        'widgets'   => [
            'calendar'      => 'Calendario',
            'campaign'      => 'Cabeceira da campaña',
            'header'        => 'Cabeceira',
            'preview'       => 'Previsualización da entidade',
            'random'        => 'Entidade aleatoria',
            'recent'        => 'Modificadas recentemente',
            'unmentioned'   => 'Entidades non mencionadas',
        ],
    ],
    'title'             => 'Taboleiro',
    'widgets'           => [
        'actions'                   => [
            'advanced-options'  => 'Opcións avanzadas',
        ],
        'advanced_options_boosted'  => 'As :boosted_campaigns teñen opcións avanzadas, como mostrar as integrantes dunha familia ou os atributos dunha entidade no taboleiro de campaña.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Cambiar ao día seguinte',
                'previous'  => 'Cambiar ao día anterior.',
            ],
            'events_today'      => 'Hoxe',
            'previous_events'   => 'Eventos pasados',
            'upcoming_events'   => 'Próximos eventos',
        ],
        'campaign'                  => [
            'helper'    => 'Este complemento mostrou a cabeceira da campaña. Este complemento sempre é mostrado no taboleiro por defecto.',
        ],
        'create'                    => [
            'success'   => 'Complemento engadido ao taboleiro.',
        ],
        'delete'                    => [
            'success'   => 'Complemento eliminado do taboleiro.',
        ],
        'fields'                    => [
            'dashboard' => 'Taboleiro',
            'name'      => 'Nome personalizado',
            'order'     => 'Orde',
            'text'      => 'Texto',
            'width'     => 'Anchura',
        ],
        'orders'                    => [
            'name_asc'  => 'Nome (ascendente)',
            'name_desc' => 'Nome (descendente)',
            'recent'    => 'Modificada recentemente',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Podes referenciar o nome da entidade aleatoria con {name}',
            ],
        ],
        'recent'                    => [
            'entity-header'     => 'Usar cabeceira da entidade como imaxe',
            'filters'           => 'Filtros',
            'full'              => 'Completo',
            'help'              => 'Mostra só a última entidade actualizada, pero mostra unha previsualización completa da entidade.',
            'helpers'           => [
                'entity-header'     => 'Se a entidade ten unha cabeceira (funcionalidade de campañas potenciadas), activa este complemento para usar esa imaxe no lugar da imaxe da entidade.',
                'filters'           => 'Podes filtrar o tipo de entidades que aparecen. Aprende a usar este campo visitando a páxina de axuda :link.',
                'full'              => 'Mostra a entidade completa por defecto en vez dunha previsualización.',
                'show_attributes'   => 'Mostra os atributos fixados da entidade baixo a entrada.',
                'show_members'      => 'Se a entidade é unha familia ou unha organización, mostra as súas integrantes baixo a entrada.',
            ],
            'show_attributes'   => 'Mostrar atributos fixados',
            'show_members'      => 'Mostrar integrantes',
            'singular'          => 'Singular',
            'tags'              => 'Filtra a lista de entidades modificadas recentemente con etiquetas específicas.',
            'title'             => 'Modificadas recentemente',
        ],
        'unmentioned'               => [
            'title' => 'Entidades non mencionadas',
        ],
        'update'                    => [
            'success'   => 'Complemento modificado.',
        ],
        'widths'                    => [
            '0' => 'Automática',
            '12'=> 'Completa (100%)',
            '3' => 'Un cuarto (25%)',
            '4' => 'Un tercio (33%)',
            '6' => 'Metade (50%)',
            '8' => 'Dous tercios (66%)',
        ],
    ],
];
