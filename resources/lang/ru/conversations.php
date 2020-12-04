<?php

return [
    'create'        => [
        'description'   => 'Создание нового разговора',
        'success'       => 'Разговор ":name" создан',
        'title'         => 'Новый разговор',
    ],
    'destroy'       => [
        'success'   => 'Разговор ":name" удален',
    ],
    'edit'          => [
        'description'   => 'Обновление разговора',
        'success'       => 'Разговор ":name" обновлен',
        'title'         => 'Разговор :name',
    ],
    'fields'        => [
        'messages'      => 'Сообщения',
        'name'          => 'Названия',
        'participants'  => 'Участники',
        'target'        => 'Цель',
        'type'          => 'Тип',
    ],
    'hints'         => [
        'participants'  => 'Добавьте в свой разговор участников, нажав на иконку :icon справа вверху.',
    ],
    'index'         => [
        'add'           => 'Новый разговор',
        'description'   => 'Управление категорией :name',
        'header'        => 'Разговоры в :name',
        'title'         => 'Разговоры',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Сообщение удалено',
        ],
        'is_updated'    => 'Обновлено',
        'load_previous' => 'Загрузить предыдущие сообщения',
        'placeholders'  => [
            'message'   => 'Ваше сообщение',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => 'Участник ":entity" добавлен в разговор',
        ],
        'description'   => 'Добавление или удаление участников разговора',
        'destroy'       => [
            'success'   => 'Участник ":entity" удален из Разговора',
        ],
        'modal'         => 'Участники',
        'title'         => 'Участники :name',
    ],
    'placeholders'  => [
        'name'  => 'Название разговора',
        'type'  => 'Игра, подготовка, сюжет',
    ],
    'show'          => [
        'description'   => 'Детальный вид разговора',
        'title'         => 'Разговор :name',
    ],
    'tabs'          => [
        'conversation'  => 'Разговор',
        'participants'  => 'Участники',
    ],
    'targets'       => [
        'characters'    => 'Персонажи',
        'members'       => 'Члены кампании',
    ],
];
