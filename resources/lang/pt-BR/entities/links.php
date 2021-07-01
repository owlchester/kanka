<?php

return [
    'actions'       => [
        'add'   => 'Adicionar um link',
    ],
    'create'        => [
        'success'   => 'Link :name adicionado para :entity.',
        'title'     => 'Adicionar um link para :name',
    ],
    'destroy'       => [
        'success'   => 'Link :name removido da :entity.',
    ],
    'fields'        => [
        'icon'      => 'Ícone',
        'name'      => 'Nome',
        'position'  => 'Posição',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'Ir para :name',
        'icon'      => 'Você pode personalizar o ícone exibido para o link. Use qualquer um dos ícones gratuitos de :fontawesome ou deixe este campo em branco para o padrão.',
        'leaving'   => 'Você está prestes a deixar Kanka e ir para outro domínio. A página para a qual você está saindo foi fornecida por um usuário e não é controlada pelo nosso site.',
        'url'       => 'A url que você está prestes a acessar é :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Campanhas impulsionadas podem adicionar links a entidades que apontam para sites externos.',
        'title'     => 'Links para :name',
    ],
    'unboosted'     => [
        'text'  => 'Adicionar links a fontes externas que são exibidos diretamente na entidade está reservado para :boosted-campaigns.',
        'title' => 'Recurso de campanha impulsionada',
    ],
    'update'        => [
        'success'   => 'Link :name atualizado para :entity.',
        'title'     => 'Atualizar link para :name',
    ],
];
