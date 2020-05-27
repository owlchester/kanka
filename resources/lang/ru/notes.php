<?php

return [
    'create'        => [
        'description'   => 'Создание новой Заметки.',
        'success'       => 'Заметка ":name" создана.',
        'title'         => 'Новая Заметка',
    ],
    'destroy'       => [
        'success'   => 'Заметка ":name" удалена.',
    ],
    'edit'          => [
        'success'   => 'Заметка ":note" обновлена.',
        'title'     => 'Редактирование Заметки :name',
    ],
    'fields'        => [
        'description'   => 'Описание',
        'image'         => 'Изображение',
        'is_pinned'     => 'Закреплена',
        'name'          => 'Название',
        'type'          => 'Тип',
    ],
    'hints'         => [
        'is_pinned' => 'До 3 Заметок могут быть закреплены на главной странице.',
    ],
    'index'         => [
        'add'           => 'Новая Заметка',
        'description'   => 'Управление заметками :name.',
        'header'        => 'Заметки :name',
        'title'         => 'Заметки',
    ],
    'placeholders'  => [
        'name'  => 'Название заметки',
        'type'  => 'Религия, раса, политика',
    ],
    'show'          => [
        'description'   => 'Детальный вид заметки.',
        'tabs'          => [
            'description'   => 'Описание',
        ],
        'title'         => 'Заметка :note',
    ],
];
