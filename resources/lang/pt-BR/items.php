<?php

return [
    'create'        => [
        'description'   => 'Criar um novo item',
        'success'       => 'Item \':name\' criado',
        'title'         => 'Criar um novo item',
    ],
    'destroy'       => [
        'success'   => 'Item \':name\' removido',
    ],
    'edit'          => [
        'success'   => 'Item \':name\' atualizado',
        'title'     => 'Editar Item :name',
    ],
    'fields'        => [
        'character'     => 'Personagem',
        'image'         => 'Imagem',
        'location'      => 'Local',
        'name'          => 'Nome',
        'relation'      => 'Relação',
        'type'          => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Novo Item',
        'description'   => 'Gerencie os itens de :name.',
        'header'        => 'Itens de :name',
        'title'         => 'Itens',
    ],
    'placeholders'  => [
        'character' => 'Escolha um personagem',
        'location'  => 'Escolha um local',
        'name'      => 'Nome do item',
        'type'      => 'Arma, Poção, Artefato',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de um item',
        'tabs'          => [
            'information'   => 'Informações',
        ],
        'title'         => 'Item :name',
    ],
];
