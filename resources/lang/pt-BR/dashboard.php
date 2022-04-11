<?php

return [
    'actions'       => [
        'follow'    => 'Seguir',
        'join'      => 'Entrar',
        'unfollow'  => 'Deixar de seguir',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count Módulos',
            'roles'     => ':count Cargos',
            'users'     => ':count Usuários',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Editar',
            'new'       => 'Novo dashboard',
            'switch'    => 'Trocar para dashboard',
        ],
        'boosted'       => ':bossted_campaigns podem criar dashboards customizados para cada cargo presente na campanha',
        'create'        => [
            'success'   => 'Novo dashboard :name criado',
            'title'     => 'Novo dashboard de campanha',
        ],
        'custom'        => [
            'text'  => 'Atualmente, você está editando o dashboard :name da campanha',
        ],
        'default'       => [
            'text'  => 'Atualmente, você está editando o dashboard padrão da campanha',
            'title' => 'Dashboard padrão',
        ],
        'delete'        => [
            'success'   => 'Dashboard :name removido',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copiar widgets',
            'name'          => 'Nome do Dashboard',
            'visibility'    => 'Visibilidade',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplica os widgets do dashboard :name neste novo.',
        ],
        'placeholders'  => [
            'name'  => 'Nome do Dashboard',
        ],
        'update'        => [
            'success'   => 'Dashboard :name da campanha atualizado',
            'title'     => 'Atualizar dashboard :name da campanha',
        ],
        'visibility'    => [
            'default'   => 'Padrão',
            'none'      => 'Nenhum',
            'visible'   => 'Visível',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Seguir uma campanha fará com que ela apareça no seletor de campanha (canto superior esquerdo) abaixo de suas campanhas.',
        'join'      => 'Essa campanha é aberta a novos membros. Clique para solicitar sua inscrição.',
        'setup'     => 'Configure o dashboard de sua campanha.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Entendi',
            'title'     => 'Notificação Importante',
        ],
    ],
    'recent'        => [
        'title' => ':name Modificados(as) Recentemente',
    ],
    'settings'      => [
        'title' => 'Configurações do Dashboard',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Adicionar um widget',
            'back_to_dashboard' => 'Voltar para o dashboard',
            'edit'              => 'Editar um widget',
        ],
        'title'     => 'Configuração do dashboard da campanha',
        'tutorial'  => [
            'blog'  => 'nosso tutorial',
            'text'  => 'Precisa de ajuda para configurar o dashboard de sua campanha? Leia o :blog para alguma ajuda e inspiração.',
        ],
        'widgets'   => [
            'calendar'      => 'Calendário',
            'campaign'      => 'Cabeçalho da campanha',
            'header'        => 'Cabeçalho',
            'preview'       => 'Preview da entidade',
            'random'        => 'Entidade aleatória',
            'recent'        => 'Modificado recentemente',
            'unmentioned'   => 'Entidades não mencionadas',
        ],
    ],
    'title'         => 'Dashboard',
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Opções avançadas',
            'delete-confirm'    => 'esse widget',
        ],
        'advanced_options_boosted'  => ':boosted_campaigns têm opções avançadas, como mostrar membros de uma família ou atributos da entidade no dashboard.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Mudar data para o próximo dia',
                'previous'  => 'Mudar data para o dia anterior',
            ],
            'events_today'      => 'Hoje',
            'previous_events'   => 'Anterior',
            'upcoming_events'   => 'Próximo',
        ],
        'campaign'                  => [
            'helper'    => 'Este widget mostra o cabeçalho da campanha. Este widget é sempre mostrado no painel padrão.',
        ],
        'create'                    => [
            'success'   => 'Widget adicionado ao dashboard',
        ],
        'delete'                    => [
            'success'   => 'Widget removido so dashboard',
        ],
        'fields'                    => [
            'dashboard'         => 'Dashboard',
            'name'              => 'Nome do widget personalizado',
            'optional-entity'   => 'Link para entidade',
            'order'             => 'Ordenação',
            'text'              => 'Texto',
            'width'             => 'Largura',
        ],
        'orders'                    => [
            'name_asc'  => 'Nome Ascendente',
            'name_desc' => 'Nome Descendente',
            'recent'    => 'Recentemente modificado',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Você pode fazer referência ao nome da entidade aleatória com {name}',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtro avançado',
            'advanced_filters'  => [
                'mentionless'   => 'Sem Mencionar (entidades que não mencionam outras entidades)',
                'unmentioned'   => 'Não Mencionado (entidades que não são mencionadas por outras entidades)',
            ],
            'entity-header'     => 'Use o cabeçalho da entidade como imagem',
            'filters'           => 'Filtros',
            'full'              => 'Inteiro',
            'help'              => 'Mostra apenas a última entidade atualizada, mas mostra uma visualização completa da entidade',
            'helpers'           => [
                'entity-header'     => 'Se sua entidade tiver um cabeçalho de entidade (recurso de campanha impulsionada), defina este widget para usar essa imagem em vez da imagem da entidade.',
                'filters'           => 'Você pode filtrar o tipo de entidades que aparecem. Aprenda a usar este campo visitando a página auxiliar :link.',
                'full'              => 'Exibe a entrada da entidade inteira por padrão em vez de uma visualização.',
                'show_attributes'   => 'Mostra os atributos fixados da entidade abaixo da entrada.',
                'show_members'      => 'Se a entidade for uma família ou organização, mostra seus membros abaixo da entrada.',
                'show_relations'    => 'Mostrar as relações fixadas da entidade abaixo da entrada.',
            ],
            'show_attributes'   => 'Mostrar atributos fixos',
            'show_members'      => 'Mostrar membros',
            'show_relations'    => 'Mostrar relações fixadas',
            'singular'          => 'Singular',
            'tags'              => 'Filtre a lista de entidades modificadas recentemente em tags específicas.',
            'title'             => 'Modificado recentemente',
        ],
        'unmentioned'               => [
            'title' => 'Entidades não mencionadas',
        ],
        'update'                    => [
            'success'   => 'Widget modificado',
        ],
        'widths'                    => [
            '0' => 'Automático',
            '12'=> 'Inteiro (100%)',
            '3' => 'Minúsculo (25%)',
            '4' => 'Pequeno (33%)',
            '6' => 'Metade (50%)',
            '8' => 'Largo (66%)',
            '9' => 'Grande (75%)',
        ],
    ],
];
