<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Engadir á etiqueta',
        ],
    ],
    'create'        => [
        'title' => 'Nova etiqueta',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Subetiquetas',
        'is_auto_applied'   => 'Aplicar automaticamente a novas entidades',
    ],
    'helpers'       => [
        'no_children'   => 'Non hai ningunha entidade con esta etiqueta.',
    ],
    'hints'         => [
        'children'          => 'Esta lista contén todas as entidades que pertencen a esta etiqueta ou ás súas subetiquetas.',
        'is_auto_applied'   => 'Marca esta opción para aplicar automaticamente esta etiqueta a todas as novas entidades que cres.',
        'tag'               => 'Abaixo están mostradas todas as etiquetas directamente baixo esta etiqueta.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Tradicións, guerras, historia, relixión, vexiloloxía...',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Subetiquetas',
        ],
    ],
    'tags'          => [],
];
