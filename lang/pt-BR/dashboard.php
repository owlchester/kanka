<?php

return [
    'actions'       => [
        'customise' => 'Personalizar dashboard',
        'follow'    => 'Seguir',
        'join'      => 'Entrar',
        'unfollow'  => 'Deixar de seguir',
    ],
    'campaigns'     => [],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Editar nome & permissões',
            'new'       => 'Novo Dashboard',
            'switch'    => 'Trocar para dashboard',
        ],
        'create'        => [
            'helper'    => 'Crie um novo dashboard para :name e atribua quais cargos podem vê-lo ou tê-lo como dashboard padrão.',
            'success'   => 'Novo dashboard :name da campanha criado',
            'title'     => 'Novo Dashboard de Campanha',
        ],
        'custom'        => [
            'text'  => 'Atualmente você está editando o dashboard :name da campanha.',
        ],
        'default'       => [
            'text'  => 'Atualmente você está editando o dashboard padrão da campanha.',
            'title' => 'Dashboard Padrão',
        ],
        'delete'        => [
            'success'   => 'Dashboard :name removido.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copiar widgets',
            'name'          => 'Nome do dashboard',
            'visibility'    => 'Visibilidade',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplica os widgets do dashboard :name neste novo.',
        ],
        'pitch'         => 'Crie vários dashboards com permissões personalizadas para cada cargo da campanha.',
        'placeholders'  => [
            'name'  => 'Nome do dashboard',
        ],
        'update'        => [
            'success'   => 'Dashboard :name da campanha atualizado.',
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
    ],
    'notifications' => [],
    'recent'        => [],
    'settings'      => [],
    'setup'         => [
        'actions'   => [
            'add'               => 'Adicionar um widget',
            'back_to_dashboard' => 'Voltar para o dashboard',
            'edit'              => 'Editar um widget',
            'new'               => 'Novo widget de :type',
        ],
        'reorder'   => [
            'helper'    => 'Arraste-me para me mover',
            'success'   => 'Widgets reordenados.',
        ],
        'title'     => 'Configurar Dashboard',
        'tutorial'  => [
            'blog'  => 'nosso tutorial',
            'text'  => 'Precisa de ajuda para configurar o dashboard de sua campanha? Leia o :blog para alguma ajuda e inspiração.',
        ],
        'widgets'   => [
            'calendar'      => 'Calendário',
            'campaign'      => 'Cabeçalho da campanha',
            'header'        => 'Cabeçalho',
            'preview'       => 'Pré-visualização da entidade',
            'random'        => 'Entidade aleatória',
            'recent'        => 'Lista de entidade',
            'unmentioned'   => 'Lista de entidades não mencionadas',
            'welcome'       => 'Boas-vindas',
        ],
    ],
    'title'         => 'Dashboard',
    'widgets'       => [
        'advanced_options_boosted'  => 'Habilite mais opções como mostrar fixados com uma :boosted_campaign.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Alterar data para o dia seguinte',
                'previous'  => 'Alterar data para o dia anterior',
            ],
            'previous_events'   => 'Anterior',
            'upcoming_events'   => 'Posterior',
        ],
        'campaign'                  => [
            'helper'    => 'Este widget exibe o cabeçalho da campanha. Este widget é sempre exibido no dashboard padrão.',
        ],
        'create'                    => [
            'helper'            => 'Selecione um tipo de widget para adicionar ao dashboard :name.',
            'helper-default'    => 'Selecione um tipo de widget para adicionar ao dashboard padrão.',
            'success'           => 'Widget adicionado ao dashboard.',
            'title'             => 'Novo widget',
        ],
        'delete'                    => [
            'success'   => 'Widget removido so dashboard.',
        ],
        'fields'                    => [
            'class'             => 'Classe CSS',
            'dashboard'         => 'Dashboard',
            'name'              => 'Nome personalizado do widget',
            'optional-entity'   => 'Link para entidade',
            'order'             => 'Ordenação',
            'size'              => 'Tamanho',
            'width'             => 'Largura',
        ],
        'helpers'                   => [
            'class'     => 'Defina uma classe CSS personalizada para adicionar ao widget.',
            'filters'   => 'Clique para aprender sobre as opções de filtro disponíveis.',
        ],
        'orders'                    => [
            'name_asc'  => 'Nome ascendente',
            'name_desc' => 'Nome descendente',
            'oldest'    => 'Mais antigo modificado',
            'recent'    => 'Recentemente modificado',
        ],
        'preview'                   => [
            'displays'  => [
                'expand'    => 'Introdução expansível',
                'full'      => 'Introdução completa',
            ],
            'fields'    => [
                'display'   => 'Exibir',
            ],
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Você pode fazer referência ao nome da entidade aleatória com {name}',
            ],
            'type'      => [
                'all'   => 'Tudo',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtro avançado',
            'advanced_filters'  => [
                'mentionless'   => 'Sem Menções (entidades que não mencionam outras entidades)',
                'unmentioned'   => 'Não Mencionadas (entidades que não são mencionadas por outras entidades)',
            ],
            'all-entities'      => 'Todas entidades',
            'entity-header'     => 'Use o cabeçalho da entidade como imagem',
            'filters'           => 'Filtros',
            'help'              => 'Exiba somente a primeira entidade como uma prévia em vez de uma lista.',
            'helpers'           => [
                'entity-header'     => 'Se sua entidade tiver um cabeçalho de entidade (recurso de campanha aprimorada), defina este widget para usar essa imagem ao invés da imagem da entidade.',
                'show_attributes'   => 'Exiba os atributos fixados da entidade abaixo da introdução.',
                'show_members'      => 'Se a entidade for uma família ou organização, exiba seus membros abaixo da introdução.',
                'show_relations'    => 'Mostrar as relações fixadas da entidade abaixo da introdução.',
            ],
            'show_attributes'   => 'Mostrar atributos fixados',
            'show_members'      => 'Mostrar membros',
            'show_relations'    => 'Mostrar relações fixadas',
            'singular'          => 'Pré-visualização',
            'tags'              => 'Filtrar a lista de entidades com tags especificadas.',
            'title'             => 'Lista de entidade',
        ],
        'tabs'                      => [
            'advanced'  => 'Avançado',
            'setup'     => 'Configurar',
        ],
        'unmentioned'               => [
            'title' => 'Entidades não mencionadas',
        ],
        'update'                    => [
            'success'   => 'Widget modificado.',
        ],
        'welcome'                   => [
            'helper'    => 'Este widget exibe uma mensagem de boas-vindas no painel que inclui links úteis para novos usuários do Kanka.',
        ],
        'widths'                    => [
            '0' => 'Automático',
            '12'=> 'Completo (100%)',
            '3' => 'Minúsculo (25%)',
            '4' => 'Pequeno (33%)',
            '6' => 'Metade (50%)',
            '8' => 'Largo (66%)',
            '9' => 'Grande (75%)',
        ],
    ],
];
