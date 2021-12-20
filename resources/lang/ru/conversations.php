<?php

return [
    'create'        => [
        'success'   => 'Разговор ":name" создан.',
        'title'     => 'Новый разговор',
    ],
    'destroy'       => [
        'success'   => 'Разговор ":name" удален.',
    ],
    'edit'          => [
        'success'   => 'Разговор ":name" обновлен.',
        'title'     => 'Разговор :name',
    ],
    'fields'        => [
        'is_closed'     => 'Закрыт',
        'messages'      => 'Сообщения',
        'name'          => 'Название',
        'participants'  => 'Участники',
        'target'        => 'Участники',
        'type'          => 'Тип',
    ],
    'hints'         => [
        'participants'  => 'Добавьте в разговор участников, нажав на иконку :icon справа вверху.',
    ],
    'index'         => [
        'add'       => 'Новый разговор',
        'header'    => 'Разговоры в :name',
        'title'     => 'Разговоры',
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
        'create'    => [
            'success'   => 'Участник ":entity" добавлен в разговор.',
        ],
        'destroy'   => [
            'success'   => 'Участник ":entity" удален из разговора.',
        ],
        'modal'     => 'Участники',
        'title'     => 'Участники :name',
    ],
    'placeholders'  => [
        'name'  => 'Название разговора',
        'type'  => 'Игра, подготовка, сюжет',
    ],
    'show'          => [
        'is_closed' => 'Разговор закрыт.',
        'title'     => 'Разговор :name',
    ],
    'tabs'          => [
        'conversation'  => 'Разговор',
        'participants'  => 'Участники',
    ],
    'targets'       => [
        'characters'    => 'Персонажи',
        'members'       => 'Участники кампании',
    ],
];
