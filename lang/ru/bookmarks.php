<?php

return [
    'actions'           => [
        'customise' => 'Настроить боковую панель',
    ],
    'create'            => [
        'title' => 'Новая закладка',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Закладка :name',
    ],
    'fields'            => [
        'active'            => 'Активность',
        'dashboard'         => 'Обзор',
        'default_dashboard' => 'Основной обзор',
        'filters'           => 'Фильтры',
        'menu'              => 'Страница',
        'position'          => 'Позиция',
        'random_type'       => 'Тип случайного объекта',
        'selector'          => 'Настройка закладки',
        'target'            => 'Назначение',
    ],
    'helpers'           => [
        'active'            => 'Неактивные закладки не будут показаны.',
        'dashboard'         => 'Создает закладку для одного из дополнительных обзоров кампании.',
        'default_dashboard' => 'Ссылаться к основному обзору кампании. Выбрать один из дополнительных обзоров все равно необходимо.',
        'entity'            => 'Создает закладку для объекта. Поле :menu определяет, как страница объекта будет открыта.',
        'position'          => 'Закладки в боковой панели отображаются в порядке возрастания значения этого поля.',
        'random'            => 'Создает закладку для случайного объекта. Закладку можно настроить так, чтобы она выбирала объекты только одного определенного типа.',
        'selector'          => 'Настройте, куда закладка отправляет пользователя при нажатии на нее.',
        'type'              => 'Создает закладку на один из списков объектов. Чтобы добавить фильтры, скопируйте часть URL отфильтрованного списка, стоящую после знака :?, и вставьте ее в поле :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=город',
        'menu'      => 'Страница меню (используйте последнее слово из URL нужной страницы)',
        'tab'       => '(устаревшее)',
    ],
    'random_no_entity'  => 'Невозможно выбрать случайный объект.',
    'random_types'      => [
        'any'   => 'Любой тип',
    ],
    'reorder'           => [
        'success'   => 'Порядок закладок изменен.',
        'title'     => 'Изменение порядка закладок',
    ],
    'show'              => [],
    'visibilities'      => [
        'is_active' => 'Показывать закладку в боковой панели',
    ],
];
