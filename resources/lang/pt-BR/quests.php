<?php

return [
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
    ],
    'fields'        => [
        'character'     => 'Quem deu a missão',
        'copy_elements' => 'Copiar elementos anexados na missão',
        'date'          => 'Data',
        'description'   => 'Descrição',
        'image'         => 'Imagem',
        'is_completed'  => 'Completa',
        'name'          => 'Nome',
        'quest'         => 'Missão Primária',
        'quests'        => 'Missões Secundárias',
        'role'          => 'Função',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando as missões de :parent.',
        'nested_without'=> 'Mostrando todas as missões que não tem uma missão-pai. Clique em uma linha para ver as missões-filhos.',
    ],
    'hints'         => [
        'quests'    => 'Uma "teia" de missões interligadas pode ser construída usando o campo de Missão Principal',
    ],
    'index'         => [
        'add'       => 'Nova Missão',
        'header'    => 'Missões de :name',
        'title'     => 'Missões',
    ],
    'placeholders'  => [
        'date'  => 'Data (mundo real) para a missão',
        'name'  => 'Nome da missão',
        'quest' => 'Missão Principal',
        'role'  => 'A função desta entidade na missão',
        'type'  => 'Arco de Personagem, Missão Secundária, Missão Principal',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Adicionar um elemento',
        ],
        'tabs'      => [
            'elements'  => 'Elementos',
        ],
        'title'     => 'Missão :name',
    ],
];
