<?php

return [
    'create'        => [
        'title' => 'Новый квест',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Объект :entity добавлен в квест.',
            'title'     => 'Новый элемент квеста :name',
        ],
        'destroy'   => [
            'success'   => 'Элемент :entity удален из квеста.',
        ],
        'edit'      => [
            'success'   => 'Элемент :entity обновлен.',
            'title'     => 'Редактирование элемента квеста :name',
        ],
        'fields'    => [
            'description'       => 'Описание',
            'entity_or_name'    => 'Нужно либо выбрать объект из кампании, либо дать название этому элементу.',
            'name'              => 'Название',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Копировать элементы квеста',
        'date'          => 'Дата',
        'element_role'  => 'Роль',
        'is_completed'  => 'Завершен',
        'role'          => 'Роль',
    ],
    'helpers'       => [
        'is_completed'  => 'Квест будет считаться завершенным.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Дата квеста в реальном мире',
        'entity'    => 'Выберите объект',
        'role'      => 'Роль объекта в квесте',
        'type'      => 'Арка персонажа, побочный, основной',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Добавить элемент',
        ],
        'tabs'      => [
            'elements'  => 'Элементы',
        ],
    ],
];
