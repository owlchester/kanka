<?php

return [
    'actions'       => [
        'apply_template'    => 'Aplicar um modelo de atributo',
        'manage'            => 'Gerenciar',
        'more'              => 'Mais opções',
        'remove_all'        => 'Remover Tudo',
        'save_and_edit'     => 'Aplicar e Editar',
        'save_and_story'    => 'Aplicar e Visualizar',
        'show_hidden'       => 'Mostrar atributos ocultos',
        'toggle_privacy'    => 'Privado/Público',
    ],
    'errors'        => [
        'loop'                  => 'Existe um loop infinito no cálculo desse atributo!',
        'no_attribute_selected' => 'Selecione um ou mais atributos primeiro.',
        'too_many_v2'           => 'Campos máximos atingidos (:count/:max). Exclua alguns atributos primeiro antes de poder adicionar mais.',
    ],
    'fields'        => [
        'attribute'             => 'Atributo',
        'community_templates'   => 'Modelos da Comunidade',
        'is_private'            => 'Atributos Privados',
        'is_star'               => 'Fixado',
        'preferences'           => 'Preferências',
        'template'              => 'Modelo',
        'value'                 => 'Valor',
    ],
    'filters'       => [
        'name'  => 'Nome do atributo',
        'value' => 'Valor do atributo',
    ],
    'helpers'       => [
        'delete_all'    => 'Tem certeza de que deseja excluir todos os atributos desta entidade?',
        'is_private'    => 'Permita apenas que membros do cargo :admin-role vejam os atributos desta entidade.',
        'setup'         => 'Você pode representar elementos como PV ou inteligência de uma entidade com atributos. Adicione atributos manualmente clicando no botão :manage, ou aplique aqueles de um modelo de atributo.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Atributos para :entity atualizados.',
        'title'     => 'Atributos para :name',
    ],
    'labels'        => [
        'checkbox'  => 'Nome da caixa de seleção',
        'name'      => 'Nome do atributo',
        'section'   => 'Nome da seção',
        'value'     => 'Valor do atributo',
    ],
    'live'          => [
        'success'   => 'Atributo :attribute atualizado.',
        'title'     => 'Atualizando :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Número de conquistas, Nível de Desafio, Iniciativa, População',
        'block'     => 'Nome do texto multilinhas',
        'checkbox'  => 'Nome da caixa de seleção',
        'icon'      => [
            'class' => 'FontAwesome ou RPG Awesome class: fas fa-users',
            'name'  => 'Nome do Ícone',
        ],
        'number'    => 'Valor do número',
        'random'    => [
            'name'  => 'Nome do atributo',
            'value' => '1-100 ou lista de valores separados por vírgula',
        ],
        'section'   => 'Nome da seção',
        'template'  => 'Selecione um modelo',
        'value'     => 'Valor do atributo',
    ],
    'ranges'        => [
        'text'  => 'Opções disponíveis :options',
    ],
    'sections'      => [
        'unorganised'   => 'Desorganizado',
    ],
    'show'          => [
        'hidden'    => 'Atributos Ocultos',
        'title'     => ':name Atributos',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Modelo carregado',
            'title'     => 'Carregar do modelo',
        ],
        'success'   => 'Modelo de Atributo :name aplicado em :entity',
        'title'     => 'Aplicar um modelo de atributo para :name',
    ],
    'title'         => 'Atributos',
    'toasts'        => [
        'bulk_deleted'  => 'Atributos removidos',
        'bulk_privacy'  => 'Privacidade dos atributos alternada',
        'lock'          => 'Atributo bloqueado',
        'pin'           => 'Atributo fixado',
        'unlock'        => 'Atributo desbloqueado',
        'unpin'         => 'Atributo desafixado',
    ],
    'tutorial'      => 'Atributos são pequenos pedaços de informação anexados a uma entidade. Por exemplo, um personagem pode ter uma estatística :hp e :str, enquanto um local pode ter uma estatística :pop. Isso pode ser facilmente rastreado com atributos.',
    'types'         => [
        'attribute' => 'Atributo',
        'block'     => 'Bloco',
        'checkbox'  => 'Caixa de Seleção',
        'icon'      => 'Ícone',
        'number'    => 'Número',
        'random'    => 'Aleatório',
        'section'   => 'Seção',
        'text'      => 'Texto Multilinhas',
    ],
    'update'        => [
        'success'   => 'Atributos para :entity atualizados.',
    ],
    'visibility'    => [
        'entry'     => 'O atributo é exibido no menu da entidade.',
        'private'   => 'Atributo visível apenas para membros do cargo de "Administrador".',
        'public'    => 'Atributo visível a todos os membros',
        'tab'       => 'Atributo é exibido somente no menu Atributos.',
    ],
];
