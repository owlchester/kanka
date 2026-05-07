<?php

return [
    'create'        => [
        'title' => 'Nova Missão',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'        => [
            'success'   => 'Elemento :entity adicionado à missão.',
            'title'     => 'Novo elemento para :name',
        ],
        'destroy'       => [
            'success'   => 'Elemento :entity removido.',
        ],
        'edit'          => [
            'success'   => 'Elemento :entity atualizado.',
            'title'     => 'Atualizar elemento para :name',
        ],
        'fields'        => [
            'copy_entity_entry' => 'Usar a descrição da entidade',
            'entity_or_name'    => 'Selecione uma entidade da campanha ou dê um nome para este elemento.',
        ],
        'helpers'       => [
            'copy_entity_entry' => 'Exibir a descrição da entidade vinculada em vez da descrição personalizada.',
        ],
        'placeholders'  => [
            'name'  => 'Nome do elemento',
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
        'status'        => 'Status',
    ],
    'helpers'       => [
        'is_completed'  => 'A missão é considerada concluída.',
        'status'        => 'O status atual da missão.',
    ],
    'hints'         => [
        'is_abandoned'  => 'Esta missão foi abandonada.',
        'is_completed'  => 'Esta missão está concluída.',
        'is_ongoing'    => 'Essa missão está em andamento.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Crie missões para registrar objetivos, enredos ou motivações de personagens.',
    ],
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
    'status'        => [
        'abandoned'     => 'Abandonada',
        'completed'     => 'Concluída',
        'not_started'   => 'Não Iniciada',
        'ongoing'       => 'Em Andamento',
    ],
];
