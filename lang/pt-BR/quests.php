<?php

return [
    'create'        => [
        'title' => 'Criar nova missão',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Entidade :entity adicionada à missão.',
            'title'     => 'Novo elemento para :name',
        ],
        'destroy'   => [
            'success'   => 'Elemento da missão :entity removido.',
        ],
        'edit'      => [
            'success'   => 'Elemento da missão :entity atualizado.',
            'title'     => 'Atualizar elementos da missão para :name',
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
        'character'     => 'Quem deu a missão',
        'copy_elements' => 'Copiar elementos anexados na missão',
        'date'          => 'Data',
        'element_role'  => 'Função',
        'is_completed'  => 'Completa',
        'quest'         => 'Missão Primária',
        'quests'        => 'Missões Secundárias',
        'role'          => 'Função',
    ],
    'helpers'       => [
        'is_completed'      => 'Selecione se a missão estiver considerada como completa.',
        'nested_without'    => 'Mostrando todas as missões que não tem uma missão-pai. Clique em uma linha para ver as missões-filhos.',
    ],
    'hints'         => [
        'quests'    => 'Uma "teia" de missões interligadas pode ser construída usando o campo de Missão Principal',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Data (mundo real) para a missão',
        'entity'    => 'Nome de um elemento da missão',
        'name'      => 'Nome da missão',
        'quest'     => 'Missão Principal',
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
