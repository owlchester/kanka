<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Engadir á etiqueta',
        ],
        'create'    => [
            'success'   => 'A etiqueta ":name" foi engadida á entidade.',
            'title'     => 'Engadir unha entidade a ":name"',
        ],
        'title'     => 'Subetiquetas da etiqueta ":name"',
    ],
    'create'        => [
        'title' => 'Nova etiqueta',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Subetiquetas',
        'is_auto_applied'   => 'Aplicar automaticamente a novas entidades',
        'tag'               => 'Etiqueta nai',
        'tags'              => 'Subetiquetas',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas as etiquetas que non teñen nai. Fai clic nunha liña para ver as súas subetiquetas.',
        'no_children'       => 'Non hai ningunha entidade con esta etiqueta.',
    ],
    'hints'         => [
        'children'          => 'Esta lista contén todas as entidades que pertencen a esta etiqueta ou ás súas subetiquetas.',
        'is_auto_applied'   => 'Marca esta opción para aplicar automaticamente esta etiqueta a todas as novas entidades que cres.',
        'tag'               => 'Abaixo están mostradas todas as etiquetas directamente baixo esta etiqueta.',
    ],
    'index'         => [],
    'new_tag'       => 'Nova etiqueta',
    'placeholders'  => [
        'name'  => 'Nome da etiqueta',
        'tag'   => 'Escolle unha etiqueta nai',
        'type'  => 'Tradicións, guerras, historia, relixión, vexiloloxía...',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Subetiquetas',
            'tags'      => 'Etiquetas',
        ],
    ],
    'tags'          => [
        'title' => 'Subetiquetas de ":name"',
    ],
];
