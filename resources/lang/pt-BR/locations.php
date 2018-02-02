<?php

return [
    'attributes'    => [
        'actions'       => [
            'add'   => 'Adicionar um atributo',
        ],
        'create'        => [
            'description'   => 'Definir um atributo a um local',
            'success'       => 'Atributo adicionado to :name.',
            'title'         => 'Novo atributo para :name',
        ],
        'destroy'       => [
            'success'   => 'Atributo de :name removido.',
        ],
        'edit'          => [
            'success'   => 'Atributo de :name atualizado.',
            'title'     => 'Atualizar atributo de :name',
        ],
        'fields'        => [
            'attribute' => 'Atributo',
            'value'     => 'Valor',
        ],
        'placeholders'  => [
            'attribute' => 'População, Número de inundações, Tamanho das guarnições',
            'value'     => 'Valor do atributo',
        ],
    ],
    'create'        => [
        'success'   => 'Local \':name\' criado.',
        'title'     => 'Criar um novo local',
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
        'description'   => 'Descrição',
        'history'       => 'História',
        'image'         => 'Imagem',
        'location'      => 'Local',
        'name'          => 'Nome',
        'relation'      => 'Relação',
        'type'          => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Novo Local',
        'description'   => 'Gerencie o local :name.',
        'header'        => 'Locais em :name',
        'title'         => 'Locais',
    ],
    'placeholders'  => [
        'location'  => 'Escolha uma localidade',
        'name'      => 'Nome do local',
        'type'      => 'Cidade, Reino, Ruína',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de um local',
        'tabs'          => [
            'attributes'    => 'Atributos',
            'characters'    => 'Personagens',
            'information'   => 'Informações',
            'locations'     => 'Locais',
            'relations'     => 'Relações',
        ],
        'title'         => 'Local :name',
    ],
];
