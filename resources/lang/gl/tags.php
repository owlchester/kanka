<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Engadir á etiqueta',
        ],
        'create'        => [
            'success'   => 'A etiqueta ":name" foi engadida á entidade.',
            'title'     => 'Engadir unha entidade a ":name"',
        ],
        'description'   => 'Entidades asociadas á etiqueta',
        'title'         => 'Subetiquetas da etiqueta ":name"',
    ],
    'create'        => [
        'description'   => 'Crear unha nova etiqueta',
        'success'       => 'Etiqueta ":name" creada.',
        'title'         => 'Nova etiqueta',
    ],
    'destroy'       => [
        'success'   => 'Etiqueta ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Etiqueta ":name" actualizada.',
        'title'     => 'Editar etiqueta ":name"',
    ],
    'fields'        => [
        'characters'    => 'Personaxes',
        'children'      => 'Subetiquetas',
        'name'          => 'Nome',
        'tag'           => 'Etiqueta nai',
        'tags'          => 'Subetiquetas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando as etiquetas de ":parent".',
        'nested_without'=> 'Mostrando todas as etiquetas que non teñen nai. Fai clic nunha liña para ver as súas subetiquetas.',
    ],
    'hints'         => [
        'children'  => 'Esta lista contén todas as entidades que pertencen a esta etiqueta ou ás súas subetiquetas.',
        'tag'       => 'Abaixo están mostradas todas as etiquetas directamente baixo esta etiqueta.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Vista en árbore',
        ],
        'add'           => 'Nova etiqueta',
        'description'   => 'Xestionar a etiqueta de ":name"',
        'header'        => 'Etiquetas en ":name"',
        'title'         => 'Etiquetas',
    ],
    'new_tag'       => 'Nova etiqueta',
    'placeholders'  => [
        'name'  => 'Nome da etiqueta',
        'tag'   => 'Escolle unha etiqueta nai',
        'type'  => 'Tradicións, guerras, historia, relixión, vexiloloxía...',
    ],
    'show'          => [
        'description'   => 'Vista detallada dunha etiqueta',
        'tabs'          => [
            'children'      => 'Subetiquetas',
            'information'   => 'Información',
            'tags'          => 'Etiquetas',
        ],
        'title'         => 'Etiqueta ":name"',
    ],
    'tags'          => [
        'description'   => 'Subetiquetas',
        'title'         => 'Subetiquetas de ":name"',
    ],
];
