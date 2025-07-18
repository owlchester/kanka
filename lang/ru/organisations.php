<?php

return [
    'create'        => [
        'title' => 'Новая организация',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Исчезнувшая',
        'members'       => 'Члены',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_defunct'    => 'Укажите, перестала ли эта организация существовать.',
    ],
    'index'         => [],
    'members'       => [
        'destroy'       => [
            'success'   => 'Член удален из организации.',
        ],
        'edit'          => [
            'title' => 'Редактирование члена :name',
        ],
        'fields'        => [
            'parent'    => 'Руководитель',
            'pinned'    => 'Закрепление',
            'role'      => 'Роль',
            'status'    => 'Статус активности',
        ],
        'helpers'       => [
            'all_members'   => 'Все персонажи, входящие в эту организацию или ее подорганизации.',
            'members'       => 'Все персонажи, входящие в эту организацию.',
            'pinned'        => 'Выберите, на страницах каких объектов следует закрепить это членство.',
        ],
        'pinned'        => [
            'both'  => 'Везде',
            'none'  => 'Нигде',
        ],
        'placeholders'  => [
            'parent'    => 'Руководитель этого персонажа',
            'role'      => 'Лидер, член, верховный септон, шпион',
        ],
        'status'        => [
            'active'    => 'Активен',
            'inactive'  => 'Неактивен',
            'unknown'   => 'Статус неизвестен',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Культ, банда, восстание, фэндом',
    ],
    'quests'        => [],
    'show'          => [],
];
