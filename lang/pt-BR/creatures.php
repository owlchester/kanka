<?php

return [
    'create'        => [
        'title' => 'Nova Criatura',
    ],
    'creatures'     => [
        'title' => ':name Sub-criaturas',
    ],
    'fields'        => [
        'creature'  => 'Criatura-pai',
        'creatures' => 'Sub-criaturas',
        'locations' => 'Localidades',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas as criaturas que não tem uma criatura-pai. Clique em uma linha para ver as criaturas-filhos.',
    ],
    'placeholders'  => [
        'name'  => 'Nome da criatura',
        'type'  => 'Herbívoro, Aquático, Mítica',
    ],
    'show'          => [
        'tabs'  => [
            'creatures' => 'Sub-criaturas',
        ],
    ],
];
