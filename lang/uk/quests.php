<?php

return [
    'create'        => [
        'title' => 'Новий квест',
    ],
    'elements'      => [
        'create'    => [
            'success'   => 'Елемент :entity додано до квесту.',
            'title'     => 'Новий елемент для :name',
        ],
        'destroy'   => [
            'success'   => 'Елемент :entity видалено.',
        ],
        'edit'      => [
            'success'   => 'Елемент :entity оновлено.',
            'title'     => 'Оновити елемент для :name',
        ],
        'fields'    => [
            'description'       => 'Опис',
            'entity_or_name'    => 'Або оберіть сутність для кампанії, або назвіть цей елемент.',
            'name'              => 'Назва',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Копіювати елементи, приєднані до квесту',
        'date'          => 'Дата',
        'element_role'  => 'Роль',
        'instigator'    => 'Підбурювач',
        'is_completed'  => 'Завершено',
        'role'          => 'Роль',
    ],
    'helpers'       => [
        'is_completed'  => 'Виберіть, якщо квест вважається виконаним.',
    ],
    'hints'         => [
        'quests'    => 'Мережа переплетених квестів може бути створена з використанням поля Батьківський квест.',
    ],
    'placeholders'  => [
        'date'      => 'Реальна дата квесту',
        'entity'    => 'Назва елементу з квесту',
        'role'      => 'Роль цієї сутності в квесті',
        'type'      => 'Арка персонажа, Додатковий квест, Головний',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Додати елемент',
        ],
        'tabs'      => [
            'elements'  => 'Елементи',
        ],
    ],
];
