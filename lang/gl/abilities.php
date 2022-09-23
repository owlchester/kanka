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
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'       => 'Esta lista contén todas as habilidades descendentes desta habilidade, non só as que están no nivel directamente inferior.',
        'nested_without'    => 'Mostrando todas as habilidades que non teñen unha habilidade nai. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'index'         => [
        'title' => 'Habilidades',
    ],
    'placeholders'  => [
        'charges'   => 'Número de cargas. Podes referenciar atributos desta forma: {Level}*{CHA}',
        'name'      => 'Bóla de lume, Alerta, Ataque astuto...',
        'type'      => 'Feitizo, Talento, Ataque...',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Habilidades',
            'entities'  => 'Entidades',
        ],
    ],
];
