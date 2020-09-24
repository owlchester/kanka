<?php

return [
    'characters'    => [
        'description'   => 'Personagens desta raça',
        'title'         => 'Raça :name Personagens',
    ],
    'create'        => [
        'description'   => 'Criar uma nova raça',
        'success'       => 'Raça \':name\' criada',
        'title'         => 'Nova Raça',
    ],
    'destroy'       => [
        'success'   => 'Raça \':name\' removida',
    ],
    'edit'          => [
        'success'   => 'Raça \':name\' atualizada',
        'title'     => 'Editar raça :name',
    ],
    'fields'        => [
        'characters'    => 'Personagens',
        'name'          => 'Nome',
        'race'          => 'Raça Ancestral',
        'races'         => 'Sub-raças',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Quando em Visão Aninhada, você pode ver suas Raças de maneira aninhada. Raças que não tenham Raças Ancestrais serão mostradas de modo padrão. Raças que contém Raças Descendentes podem ser clicadas para mostrar as \'crianças\'. Você pode continuar clicando até não haverem mais \'crianças\' para clicar.',
    ],
    'index'         => [
        'add'           => 'Nova raça',
        'description'   => 'Gerenciar as raças de :name',
        'header'        => 'Raças de :name',
        'title'         => 'Raças',
    ],
    'placeholders'  => [
        'name'  => 'Nome da raça',
        'type'  => 'Humano, Fada, Ciborgue',
    ],
    'races'         => [
        'description'   => 'Raças pertencentes à raça',
        'title'         => 'Raça :name sub-raças',
    ],
    'show'          => [
        'description'   => 'Visão detalhada de uma raça',
        'tabs'          => [
            'characters'    => 'Personagens',
            'menu'          => 'Menu',
            'races'         => 'Sub-raças',
        ],
        'title'         => 'Raça :name',
    ],
];
