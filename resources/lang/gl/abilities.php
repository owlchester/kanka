<?php

return [
    'abilities'     => [
        'title' => 'Habilidades fillas de :name',
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
        'nested'        => 'Na vista árbore, podes ver as túas habilidades de forma agrupada. As habilidades sen unha habilidade nai son mostradas por defecto, e podes clicar nas habilidades con subhabilidades para ver as súas fillas. Podes continuar clicando ata que non haxa máis fillas que mostrar.',
        'nested_parent' => 'Mostrando as habilidades de ":parent".',
        'nested_without'=> 'Mostrando todas as habilidades que non teñen unha habilidade nai. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'index'         => [
        'add'           => 'Nova habilidade',
        'description'   => 'Crea poderes, feitizos, talentos, e moito máis para as túas entidades.',
        'header'        => 'Habilidades de :name',
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
        'title' => 'Habilidade :name',
    ],
];
