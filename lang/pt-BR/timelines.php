<?php

return [
    'actions'       => [
        'add_element'   => 'Add elemento à era :era',
        'back'          => 'Voltar para :name',
        'edit'          => 'Editar linha do tempo',
        'save_order'    => 'Salvar nova ordem',
    ],
    'create'        => [
        'title' => 'Nova Linha do Tempo',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Copiar Elementos',
        'copy_eras'     => 'Copiar Eras',
        'eras'          => 'Eras',
        'reverse_order' => 'Ordem reversa da era',
        'timeline'      => 'Linha do Tempo Primária',
        'timelines'     => 'Linhas do Tempo',
    ],
    'helpers'       => [
        'nested_without'    => 'Exibindo todas as linhas do tempo que não tem uma linha do tempo primária. Clique em uma linha para ver as linhas do tempo secundárias.',
        'no_era_v2'         => 'Esta linha do tempo atualmente não tem nenhuma era. Adicione uma ou várias eras, após o qual você pode adicionar elementos às eras aqui.',
        'reverse_order'     => 'Habilite para exibir linhas do tempo em ordem cronológica reversa (eras antigas primeiro)',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nome da linha do tempo',
        'type'  => 'Primária, crônica Mundial, legado de um Reino',
    ],
    'reorder'       => [
        'success'   => 'Linha do tempo reordenada com sucesso.',
        'title'     => 'Reordenar a linha do tempo',
    ],
    'show'          => [
        'tabs'  => [
            'reorder'   => 'Reordenar linha do tempo',
            'timelines' => 'Linhas do tempo',
        ],
    ],
    'timelines'     => [
        'title' => 'Linhas do tempo da Linha do Tempo :name',
    ],
];
