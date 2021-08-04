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
        'success'   => 'Habilidade ":name" creada.',
        'title'     => 'Nova habilidade',
    ],
    'destroy'       => [
        'success'   => 'Habilidade ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Habilidade ":name" actualizada.',
        'title'     => 'Editar habilidade ":name"',
    ],
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
        'descendants'   => 'Esta lista contén todas as habilidades descendentes desta habilidade, non só as que están no nivel directamente inferior.',
        'nested'        => 'En árbore',
        'nested_parent' => 'Mostrando as habilidades de ":parent".',
        'nested_without'=> 'Mostrando todas as habilidades que non teñen unha habilidade nai. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'index'         => [
        'add'           => 'Nova habilidade',
        'description'   => 'Crea poderes, feitizos, talentos, e moito máis para as túas entidades.',
        'header'        => 'Habilidades de ":name"',
        'title'         => 'Habilidades',
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
        'title' => 'Habilidade ":name"',
    ],
];
