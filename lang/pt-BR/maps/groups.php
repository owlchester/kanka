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
        'helper'    => 'Adicione um novo grupo a :name. Os marcadores poderão então ser atribuídos a este grupo.',
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
    'pitch'         => [
        'max'       => [
            'helper'    => 'Você não pode adicionar mais grupos a menos que remova um existente.',
            'limit'     => 'Este mapa atingiu seu limite de grupo',
        ],
        'upgrade'   => [
            'limit'     => 'Você atingiu o limite de :limit grupos para este mapa',
            'upgrade'   => 'Faça upgrade para uma campanha premium para adicionar até :limit grupos e desbloquear ainda mais flexibilidade criativa.',
        ],
    ],
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
