<?php

return [
    'actions'   => [
        'clear'             => 'Apaga tudo',
        'first'             => 'Adiconar um fundador',
        'founder'           => 'Adicionar um novo fundador',
        'rename-relation'   => 'Renomear relação',
        'reset'             => 'Descartar mudanças',
        'save'              => 'Salvar',
    ],
    'modal'     => [
        'first-title'   => 'Selecione uma entidade',
        'helper'        => 'Substitua a entidade por outra da campanha',
        'relation'      => 'Relação',
        'title'         => 'Substituir entidade',
    ],
    'modals'    => [
        'clear'     => [
            'confirm'   => 'Tem certeza de que deseja reinicializar todos os dados da árvore genealógica?',
        ],
        'entity'    => [
            'add'       => [
                'founder'   => 'Fundador',
                'member'    => 'Membro',
                'success'   => 'Entidade adicionada.',
                'title'     => 'Adicionar uma entidade',
            ],
            'child'     => [
                'success'   => 'Filho adicionado.',
                'title'     => 'Adicionar um filho',
            ],
            'edit'      => [
                'helper'    => 'Marque esta opção se a relação for desconhecida. Um personagem pode ser adicionado mais tarde.',
                'success'   => 'Entidade atualizada.',
                'title'     => 'Atualizar uma entidade',
            ],
            'founder'   => [
                'title' => 'Adicionar um novo fundador',
            ],
            'remove'    => [
                'confirm'   => 'Tem certeza que deseja remover essa entidade da árvore genealógica?',
                'success'   => 'Entidade removida.',
            ],
        ],
        'relations' => [
            'add'       => [
                'success'   => 'Relação adicionada.',
                'title'     => 'Adicionar uma relação',
            ],
            'edit'      => [
                'success'   => 'Relação atualizada.',
                'title'     => 'Atualizar uma relação',
            ],
            'unknown'   => 'Desconhecida',
        ],
        'reset'     => [
            'confirm'   => 'Tem certeza que deseja descartar quaisquer mudanças feitas na árvore genealógica?',
        ],
    ],
    'pitch'     => 'Crie uma árvore genealógica detalhada para as famílias da campanha.',
    'success'   => [
        'cleared'   => 'Árvore genealógica apagada.',
        'reseted'   => 'Árvore genealógica foi redefinida.',
        'saved'     => 'Árvore genealógica salva.',
    ],
    'title'     => 'Árvore Genealógica :name',
    'unknown'   => 'não estabelecido',
];
