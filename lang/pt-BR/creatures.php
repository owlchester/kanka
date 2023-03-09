<?php

return [
    'create'        => [
        'title' => 'Nova Criatura',
    ],
    'creatures'     => [
        'title' => 'Sub-criaturas de :name',
    ],
    'fields'        => [
        'creature'  => 'Criatura Primária',
        'creatures' => 'Sub-criaturas',
        'locations' => 'Locais',
    ],
    'helpers'       => [
        'nested_without'    => 'Exibindo todas as criaturas que não tem uma criatura primária. Clique em uma linha para ver as criaturas secundárias.',
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
