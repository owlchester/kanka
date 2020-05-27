<?php

return [
    'create'        => [
        'description'   => 'Создание нового Разговора',
        'success'       => 'Разговор ":name" создан.',
        'title'         => 'Новый Разговор',
    ],
    'destroy'       => [
        'success'   => 'Разговор ":name" удален.',
    ],
    'edit'          => [
        'description'   => 'Обновление Разговора',
        'success'       => 'Разговор ":name" обновлен.',
        'title'         => 'Разговор :name',
    ],
    'fields'        => [
        'messages'      => 'Сообщения',
        'name'          => 'Названия',
        'participants'  => 'Участники',
        'target'        => 'Участники',
        'type'          => 'Тип',
    ],
    'hints'         => [
        'participants'  => 'Добавьте в свой Разговор участников, нажав на иконку :icon справа вверху.',
    ],
    'index'         => [
        'add'           => 'Новый Разговор',
        'description'   => 'Управление категорией :name.',
        'header'        => 'Разговоры в :name',
        'title'         => 'Разговоры',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Сообщение удалено.',
        ],
        'is_updated'    => 'Обновлено',
        'load_previous' => 'Загрузить предыдущие сообщения',
        'placeholders'  => [
            'message'   => 'Ваше сообщение',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => 'Участник :entity добавлен в Разговор.',
        ],
        'description'   => 'Добавление или удаление участников Разговора.',
        'destroy'       => [
            'success'   => 'Участник :entity удален из Разговора',
        ],
        'modal'         => 'Участники',
        'title'         => 'Участники :name',
    ],
    'placeholders'  => [
        'name'  => 'Название Разговора',
        'type'  => 'Игровой, подготовка, выдуманный',
    ],
    'show'          => [
        'description'   => 'Детальный вид разговора.',
        'title'         => 'Разговор :name',
    ],
    'tabs'          => [
        'conversation'  => 'Разговор',
        'participants'  => 'Участники',
    ],
    'targets'       => [
        'characters'    => 'Персонажи',
        'members'       => 'Члены',
    ],
];
