<?php

return [
    'abilities'     => [
        'title' => 'Habilidades fillas de ":name"',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Engadir habilidade á entidade',
        ],
        'create'        => [
            'success'   => 'A habilidade ":name" foi engadida á entidade.',
            'title'     => 'Engadir unha entidade a ":name"',
        ],
        'description'   => 'Entidades coa habilidade',
        'title'         => 'Entidades coa habilidade ":name"',
    ],
    'create'        => [
        'title' => 'Nova habilidade',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Entidades coa habilidade ":name"',
    ],
    'fields'        => [
        'abilities' => 'Habilidades',
        'ability'   => 'Habilidade nai',
        'charges'   => 'Cargas',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas as habilidades que non teñen unha habilidade nai. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Número de cargas. Podes referenciar atributos desta forma: {Level}*{CHA}',
        'name'      => 'Bóla de lume, Alerta, Ataque astuto...',
        'type'      => 'Feitizo, Talento, Ataque...',
    ],
    'reorder'       => [
        'parentless'    => 'Sen habilidade nai',
        'success'       => 'Habilidades reordenadas exitosamente.',
        'title'         => 'Reordenar as habilidades',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Habilidades',
            'entities'  => 'Entidades',
            'reorder'   => 'Reordenar habilidades',
        ],
    ],
];
