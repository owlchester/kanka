<?php

return [
    'actions'       => [
        'add'   => 'Adicionar novo grupo',
    ],
    'bulks'         => [
        'delete'    => '{1} Removido :count grupo.|[2,*] Removidos :count grupos.',
        'patch'     => '{1} Atualizado :count grupo.|[2,*] Atualizados :count grupos.',
    ],
    'create'        => [
        'success'   => 'Grupo :name criado com sucesso',
        'title'     => 'Novo grupo',
    ],
    'delete'        => [
        'success'   => 'Grupo :name deletado',
    ],
    'edit'          => [
        'success'   => 'Grupo :name atualizado com sucesso',
        'title'     => 'Editar grupo :name',
    ],
    'fields'        => [
        'is_shown'  => 'Mostrar marcadores do grupo',
        'position'  => 'Posição',
    ],
    'helper'        => [
        'amount_v3' => 'Os marcadores podem ser agrupados usando grupos de mapas. Cada grupo pode ser clicado ao explorar um mapa para mostrar ou ocultar rapidamente todos os marcadores nele.',
    ],
    'hints'         => [
        'is_shown'  => 'Se assinalado, os marcadores do grupo serão mostrados no mapa como padrão.',
    ],
    'index'         => [
        'title' => 'Grupos de :name',
    ],
    'pitch'         => [
        'error' => 'Número máximo de grupos alcançados.',
        'until' => 'Crie até :max grupos para cada mapa.',
    ],
    'placeholders'  => [
        'name'          => 'Lojas, Tesouros, NPCs',
        'position'      => 'Campo opcional para definir a ordem em que os grupos aparecem.',
        'position_list' => 'Depois de :name',
    ],
    'reorder'       => [
        'save'      => 'Salvar nova ordem',
        'success'   => '{1} Reordenado :count grupo.|[2,*] Reordenados :count grupos.',
        'title'     => 'Reordenar grupos',
    ],
];
