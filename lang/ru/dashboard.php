<?php

return [
    'actions'       => [
        'follow'    => 'Отслеживать',
        'join'      => 'Вступить',
        'unfollow'  => 'Перестать отслеживать',
    ],
    'campaigns'     => [],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Изменить параметры',
            'new'       => 'Новый обзор',
            'switch'    => 'Сменить обзор',
        ],
        'create'        => [
            'success'   => 'Обзор ":name" создан.',
            'title'     => 'Новый обзор кампании',
        ],
        'custom'        => [
            'text'  => 'Вы редактируете обзор :name этой кампании.',
        ],
        'default'       => [
            'text'  => 'Вы редактируете основной обзор этой кампании.',
            'title' => 'Основной обзор',
        ],
        'delete'        => [
            'success'   => 'Обзор ":name" удален.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Копировать виджеты',
            'name'          => 'Название обзора',
            'visibility'    => 'Доступ',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Копировать виджеты из обзора :name в новый обзор.',
        ],
        'pitch'         => 'Создавайте дополнительные обзоры с разрешениями для каждой роли кампании.',
        'placeholders'  => [
            'name'  => 'Название обзора',
        ],
        'update'        => [
            'success'   => 'Обзор ":name" обновлен.',
            'title'     => 'Редактирование обзора :name',
        ],
        'visibility'    => [
            'default'   => 'Основной',
            'none'      => 'Недоступный',
            'visible'   => 'Дополнительный',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Кампании, которые вы отслеживаете, находятся в переключателе кампаний (слева вверху) ниже ваших кампаний.',
        'join'      => 'Эта кампания открыта для новых участников. Нажмите, чтобы отправить заявку на вступление.',
    ],
    'notifications' => [],
    'recent'        => [],
    'settings'      => [],
    'setup'         => [
        'actions'   => [
            'add'               => 'Добавить виджет',
            'back_to_dashboard' => 'Назад к обзору',
            'edit'              => 'Редактирование виджета',
        ],
        'reorder'   => [
            'success'   => 'Порядок виджетов изменен.',
        ],
        'title'     => 'Настройка обзора кампании',
        'tutorial'  => [
            'blog'  => 'наше руководство',
            'text'  => 'Нужна помощь с настройкой обзора кампании? Читайте :blog для пояснения и вдохновения.',
        ],
        'widgets'   => [
            'calendar'      => 'Календарь',
            'campaign'      => 'Заголовок кампании',
            'header'        => 'Заголовок',
            'preview'       => 'Объект',
            'random'        => 'Случайный объект',
            'recent'        => 'Список объектов',
            'unmentioned'   => 'Неупомянутые объекты',
        ],
    ],
    'title'         => 'Обзор кампании',
    'widgets'       => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Изменить дату на следующий день',
                'previous'  => 'Изменить дату на предыдущий день',
            ],
            'previous_events'   => 'Прошедшие',
            'upcoming_events'   => 'Будущие',
        ],
        'campaign'      => [
            'helper'    => 'Этот виджет отображает заголовок кампании. Он всегда находится в основном обзоре кампании.',
        ],
        'create'        => [
            'success'   => 'Виджет добавлен в обзор.',
        ],
        'delete'        => [
            'success'   => 'Виджет удален из обзора.',
        ],
        'fields'        => [
            'class'             => 'CSS класс',
            'dashboard'         => 'Обзор',
            'name'              => 'Заголовок виджета',
            'optional-entity'   => 'Ссылка на объект',
            'order'             => 'Сортировка',
            'size'              => 'Размер',
            'width'             => 'Ширина',
        ],
        'helpers'       => [
            'class'     => 'Задайте CSS класс для этого виджета.',
            'filters'   => 'Нажмите, чтобы посмотреть доступные параметры фильтрации.',
        ],
        'orders'        => [
            'name_asc'  => 'По названию (А - Я)',
            'name_desc' => 'По названию (Я - А)',
            'recent'    => 'По дате изменения',
        ],
        'random'        => [
            'helpers'   => [
                'name'  => 'Чтобы вставить название случайного объекта, напишите "{name}".',
            ],
        ],
        'recent'        => [
            'advanced_filter'   => 'Дополнительный фильтр',
            'advanced_filters'  => [
                'mentionless'   => 'Неупомянающие (объекты, в статьях которых нет упоминаний других объектов)',
                'unmentioned'   => 'Неупомянутые (объекты, упоминаний которых нет в статьях других объектов)',
            ],
            'entity-header'     => 'Использовать изображение заголовка объекта',
            'filters'           => 'Фильтры',
            'help'              => 'Показывать только первый элемент, а не список.',
            'helpers'           => [
                'entity-header'     => 'Если у объекта есть изображение заголовка (функция усиленных кампаний), этот виджет будет использовать его, а не основное изображение объекта.',
                'show_attributes'   => 'Показывать закрепленные атрибуты объекта ниже текста статьи.',
                'show_members'      => 'Если объект - семья или организация, показывать его членов ниже текста статьи.',
                'show_relations'    => 'Показывать закрепленные связи объекта ниже текста статьи.',
            ],
            'show_attributes'   => 'Показывать закреп. атрибуты',
            'show_members'      => 'Показывать членов',
            'show_relations'    => 'Показывать закреп. связи',
            'singular'          => 'Один объект',
            'tags'              => 'В списке будут показаны только объекты с этими тэгами.',
            'title'             => 'Список объектов',
        ],
        'tabs'          => [
            'advanced'  => 'Дополнительно',
            'setup'     => 'Основное',
        ],
        'unmentioned'   => [
            'title' => 'Неупомянутые объекты',
        ],
        'update'        => [
            'success'   => 'Виджет обновлен.',
        ],
        'widths'        => [
            '0' => 'Авто',
            '12'=> 'Вся страница (100%)',
            '3' => 'Маленькая (25%)',
            '4' => 'Средняя (33%)',
            '6' => 'Половина страницы (50%)',
            '8' => 'Широкая (66%)',
            '9' => 'Большая (75%)',
        ],
    ],
];
