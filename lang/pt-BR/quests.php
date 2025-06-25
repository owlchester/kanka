<?php

return [
    'create'        => [
        'title' => 'Nova Missão',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Elemento :entity adicionado à missão.',
            'title'     => 'Novo elemento para :name',
        ],
        'destroy'   => [
            'success'   => 'Elemento :entity removido.',
        ],
        'edit'      => [
            'success'   => 'Elemento :entity atualizado.',
            'title'     => 'Atualizar elemento para :name',
        ],
        'fields'    => [
            'description'       => 'Descrição',
            'entity_or_name'    => 'Selecione uma entidade da campanha ou dê um nome para este elemento.',
            'name'              => 'Nome',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Copiar elementos anexados à missão',
        'date'          => 'Data',
        'element_role'  => 'Função',
        'instigator'    => 'Instigador',
        'is_completed'  => 'Concluída',
        'location'      => 'Local inicial',
        'role'          => 'Função',
    ],
    'helpers'       => [
        'is_completed'  => 'A missão é considerada concluída.',
    ],
    'hints'         => [
        'quests'    => 'Uma rede de missões interligadas pode ser construída usando o campo de Missão Primária.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Data do mundo real para a missão',
        'entity'    => 'Nome de um elemento da missão',
        'location'  => 'O local de início da missão',
        'role'      => 'A função desta entidade na missão',
        'type'      => 'Arco de Personagem, Missão Secundária, Missão Principal',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Adicionar um elemento',
        ],
        'tabs'      => [
            'elements'  => 'Elementos',
        ],
    ],
];
