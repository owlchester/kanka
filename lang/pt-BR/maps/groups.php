<?php

return [
    'actions'       => [
        'add'   => 'Adicionar um novo grupo',
    ],
    'bulks'         => [
        'delete'    => '{1} Removido :count grupo.|[2,*] Removidos :count grupos.',
        'patch'     => '{1} Atualizado :count grupo.|[2,*] Atualizados :count grupos.',
    ],
    'create'        => [
        'success'   => 'Grupo :name criado.',
        'title'     => 'Novo Grupo',
    ],
    'delete'        => [
        'success'   => 'Grupo :name removido.',
    ],
    'edit'          => [
        'success'   => 'Grupo :name atualizado.',
        'title'     => 'Editar Grupo :name',
    ],
    'fields'        => [
        'is_shown'  => 'Exibir marcadores do grupo',
        'position'  => 'Posição',
    ],
    'helper'        => [
        'amount_v3' => 'Os marcadores podem ser agrupados usando grupos de mapas. Cada grupo pode ser clicado ao explorar um mapa para exibir ou ocultar rapidamente todos os marcadores nele.',
    ],
    'hints'         => [
        'is_shown'  => 'Se assinalado, os marcadores do grupo serão exibidos no mapa por padrão.',
    ],
    'index'         => [
        'title' => 'Grupos de :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'name'          => 'Lojas, Tesouros, PdMs',
        'position'      => 'Primeiro',
        'position_list' => 'Depois de :name',
    ],
    'reorder'       => [
        'save'      => 'Salvar nova ordem',
        'success'   => '{1} Reordenado :count grupo.|[2,*] Reordenados :count grupos.',
        'title'     => 'Reordenar grupos',
    ],
];
