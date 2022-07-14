<?php

return [
    'create'        => [
        'title' => 'Новый предмет',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Персонаж',
        'image'     => 'Изображение',
        'location'  => 'Локация',
        'name'      => 'Название',
        'price'     => 'Цена',
        'size'      => 'Размеры',
        'type'      => 'Тип',
    ],
    'index'         => [
        'title' => 'Предметы',
    ],
    'inventories'   => [
        'title' => 'Инвентари с предметом :name',
    ],
    'placeholders'  => [
        'name'  => 'Название предмета',
        'price' => 'Цена предмета',
        'size'  => 'Размер, вес, габариты',
        'type'  => 'Оружие, зелье, артефакт',
    ],
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Инвентари',
        ],
    ],
];
