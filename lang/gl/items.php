<?php

return [
    'create'        => [
        'title' => 'Novo obxecto',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personaxe',
        'image'     => 'Imaxe',
        'item'      => 'Obxecto pai',
        'items'     => 'Obxectos fillos',
        'location'  => 'Localización',
        'name'      => 'Nome',
        'price'     => 'Prezo',
        'size'      => 'Tamaño',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todos os obxectos que non teñen un obxecto pai. Fai clic nunha fila para ver os seus fillos.',
    ],
    'hints'         => [
        'items' => 'Organiza obxectos usando o campo de obxecto pai.',
    ],
    'index'         => [
        'title' => 'Obxectos',
    ],
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
