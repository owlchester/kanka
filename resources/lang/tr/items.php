<?php

return [
    'create'        => [
        'title' => 'Yeni Eşya',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Karakter',
        'image'     => 'Görsel',
        'location'  => 'Konum',
        'name'      => 'Ad',
        'price'     => 'Fiyat',
        'size'      => 'Boyut',
        'type'      => 'Tür',
    ],
    'index'         => [
        'title' => 'Eşyalar',
    ],
    'inventories'   => [
        'title' => ':name Eşyası Envanterleri',
    ],
    'placeholders'  => [
        'character' => 'Bir karakter seçin',
        'location'  => 'Bir konum seçin',
        'name'      => 'Eşyanın adı',
        'price'     => 'Eşyanın fiyatı',
        'size'      => 'Boyut, Ağırlık, Ölçüler',
        'type'      => 'Silah, İksir, Artifakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Envanterler',
        ],
    ],
];
