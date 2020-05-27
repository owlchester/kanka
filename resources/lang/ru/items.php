<?php

return [
    'create'        => [
        'description'   => 'Создание нового Предмета.',
        'success'       => 'Предмет ":name" создан.',
        'title'         => 'Новый Предмет',
    ],
    'destroy'       => [
        'success'   => 'Предмет ":name" удален.',
    ],
    'edit'          => [
        'success'   => 'Прдмет ":name" удален.',
        'title'     => 'Редактирование Предмета :name',
    ],
    'fields'        => [
        'character' => 'Персонаж',
        'image'     => 'Изображение',
        'location'  => 'Локация',
        'name'      => 'Имя',
        'price'     => 'Цена',
        'relation'  => 'Связь',
        'size'      => 'Размер',
        'type'      => 'Тип',
    ],
    'index'         => [
        'add'           => 'Новый Предмет',
        'description'   => 'Управление Предметами :name',
        'header'        => 'Предметы :name',
        'title'         => 'Предметы',
    ],
    'inventories'   => [
        'description'   => 'Инвентари объектов, в которые входит Предмет.',
        'title'         => 'Инвентари Предмета :name',
    ],
    'placeholders'  => [
        'character' => 'Выберите Персонажа',
        'location'  => 'Выберите Локацию',
        'name'      => 'Название Предмета',
        'price'     => 'Цена Предмета',
        'size'      => 'Размер, вес, габариты',
        'type'      => 'Оружие, зелье, артефакт',
    ],
    'quests'        => [
        'description'   => 'Квесты, в которых участвует этот Предмет.',
        'title'         => 'Квесты Предмета :name',
    ],
    'show'          => [
        'description'   => 'Детальный вид Предмета',
        'tabs'          => [
            'information'   => 'Информация',
            'inventories'   => 'Инвентари',
            'quests'        => 'Квесты',
        ],
        'title'         => 'Предмет :name',
    ],
];
