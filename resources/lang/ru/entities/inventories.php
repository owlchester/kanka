<?php

return [
    'actions'       => [
        'add'   => 'Добавить Предмет',
    ],
    'create'        => [
        'success'   => 'Предмет :item добавлен :entity.',
        'title'     => 'Добавление Предмета :name',
    ],
    'destroy'       => [
        'success'   => 'Предмет :item удален из :entity.',
    ],
    'fields'        => [
        'amount'        => 'Количество',
        'description'   => 'Описание',
        'position'      => 'Место',
    ],
    'placeholders'  => [
        'amount'        => 'Любое количество',
        'description'   => 'Используется, поврежден, настроен',
        'position'      => 'В снаряжении, в рюкзаке, на хранении, в банке',
    ],
    'show'          => [
        'helper'    => 'Объектам можно присвоить Предметы, чтобы создать инвентарь.',
        'title'     => 'Инвентарь Объекта :name',
    ],
    'update'        => [
        'success'   => 'Предмет :name обновлен в :entity.',
        'title'     => 'Обновление Предмета :name',
    ],
];
