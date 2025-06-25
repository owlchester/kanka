<?php

return [
    'actions'           => [
        'add'   => 'Adicionar um link',
    ],
    'call-to-action'    => 'Adicione links para fontes externas nesta entidade, como DnDBeyond, e eles serão exibidos diretamente na visão geral da entidade.',
    'create'            => [
        'helper'    => 'Adicione um link externo para :name, por exemplo, para a página DnDBeyond.',
        'success'   => 'Link :name adicionado para :entity.',
        'title'     => 'Adicionar um link para :name',
    ],
    'destroy'           => [
        'success'   => 'Link :name removido.',
    ],
    'fields'            => [
        'icon'      => 'Ícone',
        'name'      => 'Nome',
        'position'  => 'Posição',
        'url'       => 'URL',
    ],
    'go'                => [
        'actions'       => [
            'confirm'   => 'Tenho certeza',
            'trust'     => 'Não me pergunte novamente',
        ],
        'description'   => 'Este link irá levá-lo para :link. Tem certeza que quer ir para lá?',
        'title'         => 'Saindo de Kanka',
    ],
    'helpers'           => [
        'icon'      => 'Você pode personalizar o ícone exibido para o link. Use qualquer um dos ícones gratuitos de :fontawesome ou deixe este campo em branco para o padrão. Encontre mais em nossa :docs.',
        'parent'    => 'Exiba este link rápido após um elemento da barra lateral, ao invés na seção de links rápidos da barra lateral.',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Campanhas impulsionadas podem adicionar links a entidades que apontam para sites externos.',
        'title'     => 'Links para :name',
    ],
    'unboosted'         => [],
    'update'            => [
        'success'   => 'Link :name atualizado para :entity.',
        'title'     => 'Atualizar link para :name',
    ],
];
