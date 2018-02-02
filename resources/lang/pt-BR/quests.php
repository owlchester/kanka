<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Adicione um personagem em uma Missão',
            'success'       => 'Personagem adicionado a :name.',
            'title'         => 'Novo Personagem para :name',
        ],
        'destroy'   => [
            'success'   => 'Missão do personagem para :name removida.',
        ],
        'edit'      => [
            'success'   => 'Personagem da Missão para :name atualizado.',
            'title'     => 'Atualizar personagem para :name',
        ],
        'fields'    => [
            'character'     => 'Personagem',
            'description'   => 'Descrição',
        ],
    ],
    'create'        => [
        'success'   => 'Missão \':name\' criada.',
        'title'     => 'Criar nova missão',
    ],
    'destroy'       => [
        'success'   => 'Missão \':name\' removida.',
    ],
    'edit'          => [
        'success'   => 'Missão \':name\' atualizada.',
        'title'     => 'Editar Missão :name',
    ],
    'fields'        => [
        'characters'    => 'Personagem',
        'description'   => 'Descrição',
        'image'         => 'Imagem',
        'locations'     => 'Locais',
        'name'          => 'Nome',
        'type'          => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nova Missão',
        'description'   => 'Gerencie as missões de :name.',
        'header'        => 'Missões de :name',
        'title'         => 'Missões',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Estabeleça um local para a Missão',
            'success'       => 'Local adicionado a :name',
            'title'         => 'Novo Local para :name',
        ],
        'destroy'   => [
            'success'   => 'Local da Missão para :name removido.',
        ],
        'edit'      => [
            'success'   => 'Local da Missão para :name atualizado.',
            'title'     => 'Atualizar local para :name',
        ],
        'fields'    => [
            'description'   => 'Descrição',
            'location'      => 'Local',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome da missão',
        'type'  => 'Arco de Personagem, Missão Secundária, Missão Principal',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Adicionar um personagem',
            'add_location'  => 'Adicionar um local',
        ],
        'description'   => 'Uma visão detalhada de uma missão',
        'tabs'          => [
            'characters'    => 'Personagens',
            'information'   => 'Informações',
            'locations'     => 'Locais',
        ],
        'title'         => 'Missão :name',
    ],
];
