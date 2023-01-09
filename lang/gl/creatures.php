<?php

return [
    'create'        => [
        'title' => 'Nova criatura',
    ],
    'creatures'     => [
        'title' => 'Subcriaturas de :name',
    ],
    'fields'        => [
        'creature'  => 'Criatura nai',
        'creatures' => 'Subcriaturas',
        'locations' => 'Localizacións',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas as criaturas que non teñen unha criatura nai. Fai clic nunha fila para ver as súas subcriaturas.',
    ],
    'placeholders'  => [
        'name'  => 'Nome da criatura',
        'type'  => 'Hervíbora, acuática, mítica...',
    ],
    'show'          => [
        'tabs'  => [
            'creatures' => 'Subcriaturas',
        ],
    ],
];
