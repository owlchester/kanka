<?php

return [
    'create'        => [
        'description'   => 'Criar um novo local',
        'success'       => 'Local \':name\' criado.',
        'title'         => 'Criar um novo local',
    ],
    'destroy'       => [
        'success'   => 'Local \':name\' removido',
    ],
    'edit'          => [
        'success'   => 'Local \':name\' atualizado.',
        'title'     => 'Editar Local :name',
    ],
    'fields'        => [
        'characters'    => 'Personagens',
        'image'         => 'Imagem',
        'location'      => 'Local',
        'locations'     => 'Locais',
        'map'           => 'Mapa',
        'name'          => 'Nome',
        'relation'      => 'Relação',
        'type'          => 'Tipo',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Visualização de Exploração',
        ],
        'add'           => 'Novo Local',
        'description'   => 'Gerencie os locais de :name.',
        'header'        => 'Locais em :name',
        'title'         => 'Locais',
    ],
    'map'           => [
        'actions'   => [
            'points'    => 'Editar Pontos',
        ],
        'helper'    => 'Clique no mapa para adicionar links para uma local, ou clique num ponto existente para removê-lo.',
        'modal'     => [
            'submit'    => 'Adicionar',
            'title'     => 'Alvo do novo ponto',
        ],
        'no_map'    => 'Por favor carregue um mapa para o local primeiro',
        'points'    => [
            'title' => 'Pontos no Mapa do Local :name',
        ],
        'success'   => 'Pontos de Mapa salvos.',
    ],
    'placeholders'  => [
        'location'  => 'Escolha uma localidade',
        'name'      => 'Nome do local',
        'type'      => 'Cidade, Reino, Ruína',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de um local',
        'tabs'          => [
            'characters'    => 'Personagens',
            'information'   => 'Informações',
            'locations'     => 'Locais',
            'map'           => 'Mapa',
        ],
        'title'         => 'Local :name',
    ],
];
