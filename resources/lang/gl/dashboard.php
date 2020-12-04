<?php

return [
    'actions'           => [
        'follow'    => 'Seguir',
        'unfollow'  => 'Deixar de seguir',
    ],
    'campaigns'         => [
        'manage'    => 'Xerir',
        'tabs'      => [
            'modules'   => ':count módulos',
            'roles'     => ':count roles',
            'users'     => ':count usuarios',
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
            'name'          => 'Nome do taboleiro',
            'visibility'    => 'Visibilidade',
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
        'setup'     => 'Configura os taboleiros da túa campaña.',
    ],
    'latest_release'    => 'Último lanzamento',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'De acordo',
            'title'     => 'Notificación importante',
        ],
    ],
    'recent'            => [
        'title' => ':name modificad@s recentemente',
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
        'calendar'      => [
            'actions'           => [
                'next'      => 'Cambiar ao día seguinte',
                'previous'  => 'Cambiar ao día anterior.',
            ],
            'events_today'      => 'Hoxe',
            'previous_events'   => 'Eventos pasados',
            'upcoming_events'   => 'Próximos eventos',
        ],
        'campaign'      => [
            'helper'    => 'Este complemento mostrou a cabeceira da campaña. Este complemento sempre é mostrado no taboleiro por defecto.',
        ],
        'create'        => [
            'success'   => 'Complemento engadido ao taboleiro.',
        ],
        'delete'        => [
            'success'   => 'Complemento eliminado do taboleiro.',
        ],
        'fields'        => [
            'name'  => 'Nome personalizado',
            'text'  => 'Texto',
            'width' => 'Anchura',
        ],
        'recent'        => [
            'entity-header' => 'Usar cabeceira da entidade como imaxe',
            'full'          => 'Completo',
            'help'          => 'Mostra só a última entidade actualizada, pero mostra unha previsualización completa da entidade.',
            'helpers'       => [
                'entity-header' => 'Se a entidade ten unha cabeceira (funcionalidade de campañas potenciadas), activa este complemento para usar esa imaxe no lugar da imaxe da entidade.',
                'full'          => 'Mostra a entidade completa por defecto en vez dunha previsualización.',
            ],
            'singular'      => 'Singular',
            'tags'          => 'Filtra a lista de entidades modificadas recentemente con etiquetas específicas.',
            'title'         => 'Modificadas recentemente',
        ],
        'unmentioned'   => [
            'title' => 'Entidades non mencionadas',
        ],
        'update'        => [
            'success'   => 'Complemento modificado.',
        ],
        'widths'        => [
            '0' => 'Automática',
            '12'=> 'Completa (100%)',
            '3' => 'Un cuarto (25%)',
            '4' => 'Un tercio (33%)',
            '6' => 'Metade (50%)',
            '8' => 'Dous tercios (66%)',
        ],
    ],
];
