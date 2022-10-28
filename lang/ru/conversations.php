<?php

return [
    'create'        => [
        'title' => 'Новый разговор',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Разговор :name',
    ],
    'fields'        => [
        'is_closed'     => 'Закрыт',
        'messages'      => 'Сообщения',
        'participants'  => 'Участники',
        'target'        => 'Участники',
    ],
    'hints'         => [
        'participants'  => 'Добавьте в разговор участников, нажав на иконку :icon справа вверху.',
    ],
    'index'         => [],
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
