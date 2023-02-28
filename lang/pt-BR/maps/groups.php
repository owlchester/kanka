<?php

return [
    'actions'       => [],
    'bulks'         => [
        'delete'    => '{1} Removido :count grupo.|[2,*] Removidos :count grupos.',
        'patch'     => '{1} Atualizado :count grupo.|[2,*] Atualizados :count grupos.',
    ],
    'create'        => [],
    'delete'        => [],
    'edit'          => [],
    'fields'        => [],
    'helper'        => [
        'amount_v3' => 'Os marcadores podem ser agrupados usando grupos de mapas. Cada grupo pode ser clicado ao explorar um mapa para mostrar ou ocultar rapidamente todos os marcadores nele.',
    ],
    'hints'         => [],
    'index'         => [
        'title' => 'Grupos de :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'position_list' => 'Depois de :name',
    ],
    'reorder'       => [
        'save'      => 'Salvar nova ordem',
        'success'   => '{1} Reordenado :count grupo.|[2,*] Reordenados :count grupos.',
        'title'     => 'Reordenar grupos',
    ],
];
