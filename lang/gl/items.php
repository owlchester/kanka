<?php

return [
    'create'        => [
        'title' => 'Novo obxecto',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personaxe',
        'item'      => 'Obxecto pai',
        'items'     => 'Obxectos fillos',
        'price'     => 'Prezo',
        'size'      => 'Tamaño',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todos os obxectos que non teñen un obxecto pai. Fai clic nunha fila para ver os seus fillos.',
    ],
    'hints'         => [
        'items' => 'Organiza obxectos usando o campo de obxecto pai.',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => 'Inventarios do obxecto ":name"',
    ],
    'placeholders'  => [
        'name'  => 'Nome do obxecto',
        'price' => 'Prezo do obxecto',
        'size'  => 'Tamaño, peso, dimensións...',
        'type'  => 'Arma, apócema, artefacto...',
    ],
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventarios',
        ],
    ],
];
