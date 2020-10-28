<?php

return [
    'actions'           => [
        'follow'    => 'Seguir',
        'unfollow'  => 'Deixar de seguir',
    ],
    'campaigns'         => [
        'manage'    => 'Gerencie suas campanhas',
        'tabs'      => [
            'modules'   => ':count Módulos',
            'roles'     => ':count Cargos',
            'users'     => ':count Usuários',
        ],
    ],
    'description'       => 'O lar de sua criatividade',
    'helpers'           => [
        'follow'    => 'Seguir uma campanha fará com que ela apareça no seletor de campanha (canto superior esquerdo) abaixo de suas campanhas.',
        'setup'     => 'Configure o dashboard de sua campanha.',
    ],
    'latest_release'    => 'Última Atualização',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Entendi',
            'title'     => 'Notificação Importante',
        ],
    ],
    'recent'            => [
        'add'           => 'Criar nova :name',
        'no_entries'    => 'Atualmente não há entidade desse tipo.',
        'title'         => ':name Modificados(as) Recentemente',
        'view'          => 'Ver Todos(as) :name',
    ],
    'settings'          => [
        'description'   => 'Customize o que você vê no seu dashboard',
        'edit'          => [
            'success'   => 'Suas modificações foram salvas.',
        ],
        'fields'        => [
            'helper'        => 'Você pode facilmente mudar o que você vê no seu dashboard. Por favor note que isso será para todas as suas campanhas, independentemente das configurações de cada uma delas.',
            'recent_count'  => 'Número de elementos recentes',
        ],
        'title'         => 'Configurações do Dashboard',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Adicionar um widget',
            'back_to_dashboard' => 'Voltar para o dashboard',
            'edit'              => 'Editar um widget',
        ],
        'title'     => 'Configuração do dashboard da campanha',
        'widgets'   => [
            'calendar'      => 'Calendário',
            'preview'       => 'Preview da entidade',
            'random'        => 'Entidade aleatória',
            'recent'        => 'Modificado recentemente',
            'unmentioned'   => 'Entidades não mencionadas',
        ],
    ],
    'title'             => 'Dashboard',
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Mudar data para o próximo dia',
                'previous'  => 'Mudar data para o dia anterior',
            ],
            'events_today'      => 'Hoje',
            'previous_events'   => 'Anterior',
            'upcoming_events'   => 'Próximo',
        ],
        'create'        => [
            'success'   => 'Widget adicionado ao dashboard',
        ],
        'delete'        => [
            'success'   => 'Widget removido so dashboard',
        ],
        'fields'        => [
            'width' => 'Largura',
        ],
        'recent'        => [
            'entity-header' => 'Use o cabeçalho da entidade como imagem',
            'full'          => 'Inteiro',
            'help'          => 'Mostra apenas a última entidade atualizada, mas mostra uma visualização completa da entidade',
            'helpers'       => [
                'entity-header' => 'Se sua entidade tiver um cabeçalho de entidade (recurso de campanha impulsionada), defina este widget para usar essa imagem em vez da imagem da entidade.',
                'full'          => 'Exibe a entrada da entidade inteira por padrão em vez de uma visualização.',
            ],
            'singular'      => 'Singular',
            'tags'          => 'Filtre a lista de entidades modificadas recentemente em tags específicas.',
            'title'         => 'Modificado recentemente',
        ],
        'unmentioned'   => [
            'title' => 'Entidades não mencionadas',
        ],
        'update'        => [
            'success'   => 'Widget modificado',
        ],
        'widths'        => [
            '0' => 'Automático',
            '12'=> 'Inteiro (100%)',
            '3' => 'Minúsculo (25%)',
            '4' => 'Pequeno (33%)',
            '6' => 'Metade (50%)',
            '8' => 'Largo (66%)',
        ],
    ],
];
