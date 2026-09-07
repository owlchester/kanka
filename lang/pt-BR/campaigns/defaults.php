<?php

return [
    'fields'    => [
        'character_personality_visibility'  => 'Visibilidade padrão da personalidade do personagem',
        'connections'                       => 'Visualização de relações da entidade',
        'connections_mode'                  => 'Estilo de mapa de relações',
        'descendants'                       => 'Filtragem padrão de sublista',
        'entity_privacy'                    => 'Visibilidade de nova entidade',
        'gallery_visibility'                => 'Visibilidade padrão da imagem da galeria',
        'post_collapsed'                    => 'Novo layout de artigo',
        'related_visibility'                => 'Visibilidade de conteúdo relacionado',
    ],
    'helpers'   => [
        'character_visibility'          => 'Define a visibilidade de traços de personalidade ao criar personagens.',
        'connections'                   => 'Escolha se as páginas de relação da entidade exibem um mapa visual ou uma lista por padrão.',
        'connections_mode'              => 'Defina o estilo de layout padrão para mapas de relacionamento (disponível na versão premium).',
        'descendants'                   => 'Ao visualizar sublistas de entidades (como os personagens de um local), exiba apenas os filhos diretos ou todos os descendentes.',
        'display'                       => 'Defina as opções de exibição padrão para páginas da entidade.',
        'entity'                        => 'Controla qual visibilidade o Kanka aplica automaticamente a novos conteúdos.',
        'entity_privacy'                => 'Define a visibilidade para personagens, locais, etc., recém-criados.',
        'gallery_visibility'            => 'Valor de visibilidade padrão ao enviar imagens para a galeria.',
        'post_collapsed'                => 'Ao criar artigos, defina o artigo como recolhido ou expandido.',
        'privacy'                       => 'Defina as configurações de visibilidade padrão para novos conteúdos. Essas configurações se aplicam quando você cria novos conteúdos e podem ser alteradas para itens individuais.',
        'private_mention_visibility'    => 'Ao mencionar uma entidade privada em conteúdo visível, controle se o nome da entidade é exibido ou ocultado.',
        'related_visibility'            => 'Controla a visibilidade de artigos, propriedades e relações adicionados a entidades.',
    ],
    'sections'  => [
        'display'   => 'Padrões de exibição de entidades',
        'entity'    => 'Padrões de entidades',
        'media'     => 'Padrões de mídias',
        'mention'   => 'Comportamento de menções',
    ],
    'tutorial'  => 'Agilize a criação de conteúdo com configurações padrão inteligentes. Escolha as definições de visibilidade padrão para entidades, artigos, imagens e outros conteúdos. Essas preferências serão aplicadas automaticamente ao criar novos conteúdos, economizando seu tempo e mantendo sua campanha organizada.',
    'update'    => [
        'success'   => 'Padrões da campanha atualizados.',
    ],
    'values'    => [
        'collapsed'     => [
            'collapsed' => 'Recolhido',
            'default'   => 'Padrão',
            'expanded'  => 'Expandido',
        ],
        'connections'   => [
            'explorer'  => 'Mapa de relacionamentos (premium)',
            'list'      => 'Interface de lista',
        ],
        'descendants'   => [
            'all'       => 'Exibir todos descendentes por padrão',
            'direct'    => 'Exibir descendentes diretos por padrão',
        ],
        'mentions'      => [
            'private'   => 'Ocultar nome do alvo',
            'visible'   => 'Exibir nome do alvo',
        ],
    ],
];
