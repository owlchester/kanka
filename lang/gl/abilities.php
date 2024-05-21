<?php

return [
    'abilities'     => [],
    'children'      => [
        'description'   => 'Entidades coa habilidade',
        'title'         => 'Entidades coa habilidade ":name"',
    ],
    'create'        => [
        'title' => 'Nova habilidade',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Cargas',
    ],
    'helpers'       => [],
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
            'entities'  => 'Entidades',
            'reorder'   => 'Reordenar habilidades',
        ],
    ],
];
