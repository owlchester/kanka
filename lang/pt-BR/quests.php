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
            'quest'             => 'Missão',
        ],
        'title'     => 'Elementos da Missão :name',
        'warning'   => [
            'editing'   => [
                'description'   => 'Parece que outra pessoa está editando este elemento de missão! Deseja voltar atrás ou ignorar este aviso, correndo o risco de perder dados? Membros atualmente editando este elemento de missão:',
            ],
        ],
    ],
    'fields'        => [
        'character'     => 'Instigador',
        'copy_elements' => 'Copiar elementos anexados na missão',
        'date'          => 'Data',
        'element_role'  => 'Cargo',
        'is_completed'  => 'Concluída',
        'quest'         => 'Missão Primária',
        'quests'        => 'Sub Missões',
        'role'          => 'Cargo',
    ],
    'helpers'       => [
        'is_completed'      => 'Selecione se a missão estiver considerada como concluída.',
        'nested_without'    => 'Exibindo todas as missões que não tem uma missão primária. Clique em uma linha para ver as missões secundárias.',
    ],
    'hints'         => [
        'quests'    => 'Uma rede de missões interligadas pode ser construída usando o campo de Missão Primária.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Data do mundo real para a missão',
        'entity'    => 'Nome de um elemento da missão',
        'name'      => 'Nome da missão',
        'quest'     => 'Missão Primária',
        'role'      => 'A função desta entidade na missão',
        'type'      => 'Arco de Personagem, Missão Secundária, Missão Principal',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Add um elemento',
        ],
        'tabs'      => [
            'elements'  => 'Elementos',
        ],
    ],
];
