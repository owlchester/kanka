<?php

return [
    'create'        => [
        'title' => 'Nova misión',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Entidade ":entity" engadida á misión.',
            'title'     => 'Novo elemento para ":name"',
        ],
        'destroy'   => [
            'success'   => 'Elemento ":entity" eliminado da misión.',
        ],
        'edit'      => [
            'success'   => 'Elemento ":entity" actualizado na misión.',
            'title'     => 'Actualizar elemento da misión ":name"',
        ],
        'fields'    => [
            'description'       => 'Descrición',
            'entity_or_name'    => 'Selecciona unha entidade ou dá un nome a este elemento.',
            'name'              => 'Nome',
            'quest'             => 'Misión',
        ],
        'title'     => 'Elementos da misión ":name"',
    ],
    'fields'        => [
        'character'     => 'Quen deu a misión',
        'copy_elements' => 'Copiar elementos ligados á misión',
        'date'          => 'Data',
        'description'   => 'Descrición',
        'element_role'  => 'Rol',
        'image'         => 'Imaxe',
        'is_completed'  => 'Completada',
        'name'          => 'Nome',
        'quest'         => 'Misión superior',
        'quests'        => 'Submisións',
        'role'          => 'Rol',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'is_completed'      => 'Selecciona se a misión é considerada completa.',
        'nested_without'    => 'Mostrando todas as misións que non teñen unha misión superior. Fai clic nunha fila para ver as súas submisións.',
    ],
    'hints'         => [
        'quests'    => 'Podes crear unha rede de misións entrelazadas usando o campo "Misión superior".',
    ],
    'index'         => [
        'title' => 'Misións',
    ],
    'placeholders'  => [
        'date'      => 'Data do mundo real para a misión',
        'entity'    => 'Nome dun elemento da misión',
        'name'      => 'Nome da misión',
        'quest'     => 'Misión superior',
        'role'      => 'O rol desta entidade na misión',
        'type'      => 'Arco de personaxe, Misión secundaria, Historia principal...',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Engadir un elemento',
        ],
        'tabs'      => [
            'elements'  => 'Elementos',
        ],
    ],
];
