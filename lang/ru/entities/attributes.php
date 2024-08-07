<?php

return [
    'actions'       => [
        'apply_template'    => 'Применить шаблон атрибутов',
        'manage'            => 'Управление',
        'more'              => 'Другое',
        'remove_all'        => 'Удалить все',
    ],
    'errors'        => [
        'loop'  => 'В вычислении этого атрибута обнаружен бесконечный цикл!',
    ],
    'fields'        => [
        'attribute'             => 'Атрибут',
        'community_templates'   => 'Шаблоны сообщества',
        'is_private'            => 'Скрыть атрибуты',
        'is_star'               => 'Закреплен',
        'template'              => 'Шаблон',
        'value'                 => 'Значение',
    ],
    'filters'       => [
        'name'  => 'Название атрибута',
        'value' => 'Значение атрибута',
    ],
    'helpers'       => [
        'delete_all'    => 'Вы уверены, что хотите удалить все атрибуты этого объекта?',
        'setup'         => 'Элементы объекта, такие как HP или интеллект, можно отображать с помощью атрибутов. Добавьте атрибуты в ручную с помощью кнопки :manage или примените шаблон атрибутов.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Атрибуты объекта ":entity" обновлены.',
        'title'     => 'Атрибуты объекта :name',
    ],
    'live'          => [
        'success'   => 'Атрибут ":attribute" обновлен.',
        'title'     => 'Редактирование :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Число побед, рейтинг опасности, инициатива, население',
        'block'     => 'Название блока',
        'checkbox'  => 'Название флажка',
        'icon'      => [
            'class' => 'Класс FontAwesome или RPG Awesome: fas fa-users',
            'name'  => 'Название иконки',
        ],
        'number'    => 'Название числа',
        'random'    => [
            'name'  => 'Название атрибута',
            'value' => 'Диапазон вида 1-100 или список значений через запятую',
        ],
        'section'   => 'Название раздела',
        'template'  => 'Выберите шаблон',
        'value'     => 'Значение атрибута',
    ],
    'show'          => [
        'title' => 'Атрибуты объекта :name',
    ],
    'template'      => [
        'success'   => 'Шаблон атрибутов ":name" применен к объекту ":entity".',
        'title'     => 'Применение шаблона атрибутов к объекту :name',
    ],
    'types'         => [
        'attribute' => 'Атрибут',
        'block'     => 'Блок текста',
        'checkbox'  => 'Флажок',
        'icon'      => 'Иконка',
        'number'    => 'Число',
        'random'    => 'Случайный',
        'section'   => 'Раздел',
        'text'      => 'Блок текста',
    ],
    'update'        => [
        'success'   => 'Атрибуты объекта ":entity" обновлены.',
    ],
    'visibility'    => [
        'entry'     => 'Этот атрибут закреплен на странице истории объекта.',
        'private'   => 'Этот атрибут виден только участникам роли "Админ".',
        'public'    => 'Этот атрибут виден всем участникам.',
        'tab'       => 'Этот атрибут отображается только во вкладке атрибутов.',
    ],
];
