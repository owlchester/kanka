<?php

return [
    'create'        => [
        'title' => 'Yeni Eşya',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Karakter',
        'price'     => 'Fiyat',
        'size'      => 'Boyut',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => ':name Eşyası Envanterleri',
    ],
    'placeholders'  => [
        'name'  => 'Eşyanın adı',
        'price' => 'Eşyanın fiyatı',
        'size'  => 'Boyut, Ağırlık, Ölçüler',
        'type'  => 'Silah, İksir, Artifakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Envanterler',
        ],
    ],
];
