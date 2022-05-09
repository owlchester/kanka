<?php

return [
    'actions'       => [
        'add_element'   => 'Adicionar novo elemento à era :era',
        'back'          => 'Voltar para :name',
        'edit'          => 'Editar linha do tempo',
        'reorder'       => 'Reordenar',
        'save_order'    => 'Salvar nova ordem',
    ],
    'create'        => [
        'success'   => 'Linha do tempo :name criada',
        'title'     => 'Nova linha do tempo',
    ],
    'destroy'       => [
        'success'   => 'Linha do tempo :name removida',
    ],
    'edit'          => [
        'success'   => 'Linha do tempo :name atualizada',
        'title'     => 'Editar linha do tempo :name',
    ],
    'fields'        => [
        'copy_elements' => 'Copiar elementos',
        'copy_eras'     => 'Copiar eras',
        'eras'          => 'Eras',
        'name'          => 'Nome',
        'reverse_order' => 'Era em ordem reversa',
        'timeline'      => 'Linha do Tempo primária',
        'timelines'     => 'Linhas do Tempo',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent'     => 'Mostrando as linhas do tempo de :parent.',
        'nested_without'    => 'Mostrando todas as linhas do tempo que não tem uma linha do tempo pai. Clique em uma linha para ver as linhas do tempo filhos.',
        'no_era'            => 'Esta linha do tempo atualmente não tem nenhuma era. As eras podem ser adicionadas na tela de edição da linha do tempo, após o qual você pode adicionar elementos nela.',
        'reorder'           => 'Arraste e solte elementos da linha do tempo para reorganizá-los',
        'reorder_tooltip'   => 'Clique aqui para permitir a ordenação manual dos elementos ao arrastar e soltar',
        'reverse_order'     => 'Habilite para mostrar linhas do tempo em ordem cronológica reversa (eras antigas primeiro)',
    ],
    'index'         => [
        'title' => 'Linhas do Tempo',
    ],
    'placeholders'  => [
        'name'  => 'Nome da linha do tempo',
        'type'  => 'Primária, crônica Mundial, legado de um Reino',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Linhas do tempo',
        ],
    ],
    'timelines'     => [
        'title' => 'Linhas do tempo de :name',
    ],
];
