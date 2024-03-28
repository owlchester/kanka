<?php

return [
    'create'        => [
        'title' => 'Nueva criatura',
    ],
    'fields'        => [
        'is_extinct'    => 'Extinta',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrar todas las criaturas que no tienen una criatura padre. Haz clic en una fila para ver las criaturas hijas.',
    ],
    'hints'         => [
        'is_extinct'    => 'Esta criatura está extinguida.',
    ],
    'placeholders'  => [
        'type'  => 'Herbívoro, Acuático, Mítico',
    ],
];
