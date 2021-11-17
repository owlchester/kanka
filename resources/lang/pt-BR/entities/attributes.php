<?php

return [
    'actions'       => [
        'add'               => 'Adicionar um atributo',
        'apply_template'    => 'Aplicar um Modelo de Atributo',
        'manage'            => 'Gerenciar',
        'more'              => 'Mais opções',
        'remove_all'        => 'Deletar tudo',
    ],
    'create'        => [
        'description'   => 'Criar um novo atributo',
        'success'       => 'Atributo :name adicionado a :entity',
        'title'         => 'Novo Atributo para :name',
    ],
    'destroy'       => [
        'success'   => 'Atributo :name para :entity removido',
    ],
    'edit'          => [
        'description'   => 'Atualizar um atributo existente',
        'success'       => 'Atributo :name para :entity atualizado',
        'title'         => 'Atualizar atributo para :name',
    ],
    'errors'        => [
        'loop'  => 'Existe um loop infinito no cálculo desse atributo!',
    ],
    'fields'        => [
        'attribute'             => 'Atributo',
        'community_templates'   => 'Modelos da Comunidade',
        'is_private'            => 'Atributos privados',
        'is_star'               => 'FIxado',
        'template'              => 'Modelo',
        'value'                 => 'Valor',
    ],
    'helpers'       => [
        'delete_all'    => 'Tem certeza de que deseja excluir todos os atributos desta entidade?',
        'setup'         => 'Você pode representar elementos como PV ou inteligência de uma entidade com atributos. Adicione atributos manualmente clicando no botão :manage, ou aplique aqueles de um modelo de atributo.',
    ],
    'hints'         => [
        'is_private'    => 'Você pode ocultar todos os atributos de uma entidade para todos os membros fora da função administrativa, tornando-a privada.',
        'is_private2'   => 'Se selecionado, apenas membros da função :admin-role podem ver os atributos dessa entidade.',
    ],
    'index'         => [
        'success'   => 'Atributos de :entity atualizados.',
        'title'     => 'Atributos de :name',
    ],
    'placeholders'  => [
        'attribute' => 'Número de conquistas, Nível de Desafio, Iniciativa, População',
        'block'     => 'Nome do bloco',
        'checkbox'  => 'Nome da caixa de seleção',
        'icon'      => [
            'class' => 'FontAwesome ou RPG Awesome class: fas fa-users',
            'name'  => 'Nome do Ícone',
        ],
        'random'    => [
            'name'  => 'Nome do Atributo',
            'value' => '1-100 ou lista de valores separados por vírgula',
        ],
        'section'   => 'Nome da seleção',
        'template'  => 'Selecione um modelo',
        'value'     => 'Valor do atributo',
    ],
    'show'          => [
        'title' => ':name Atributos',
    ],
    'template'      => [
        'success'   => 'Modelo de Atributo :name aplicado em :entity',
        'title'     => 'Aplicar um Modelo de Atributo a :name',
    ],
    'types'         => [
        'attribute' => 'Atributo',
        'block'     => 'Bloco',
        'checkbox'  => 'Caixa de seleção',
        'icon'      => 'Ícone',
        'random'    => 'Aleatório',
        'section'   => 'Seção',
        'text'      => 'Texto multilinha',
    ],
    'update'        => [
        'success'   => 'Atributos para :entity atualizados.',
    ],
    'visibility'    => [
        'entry'     => 'O atributo é exibido no menu da entidade.',
        'private'   => 'Atributo visível apenas para membros da função de Admnistrador.',
        'public'    => 'Atributos visíveis a todos os membros',
        'tab'       => 'Atributos mostrados apenas na aba de atributos',
    ],
];
