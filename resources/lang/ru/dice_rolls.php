<?php

return [
    'create'        => [
        'success'   => 'Бросок костей ":name" создан.',
        'title'     => 'Новый бросок костей',
    ],
    'destroy'       => [
        'dice_roll' => 'Бросок костей удален.',
        'success'   => 'Бросок костей ":name" удален.',
    ],
    'edit'          => [
        'success'   => 'Бросок костей ":name" обновлен.',
        'title'     => 'Редактирование броска костей :name',
    ],
    'fields'        => [
        'created_at'    => 'Бросок совершен в',
        'name'          => 'Название',
        'parameters'    => 'Параметры броска',
        'results'       => 'Результаты',
        'rolls'         => 'Броски',
    ],
    'hints'         => [
        'parameters'    => 'Какие параметры есть у бросков?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Броски костей',
            'results'   => 'Результаты',
        ],
        'title'     => 'Броски костей',
    ],
    'placeholders'  => [
        'dice_roll' => 'Бросок костей',
        'name'      => 'Название броска костей',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Бросить кости',
        ],
        'error'     => 'Не удалось выполнить бросок. Недействительные параметры.',
        'fields'    => [
            'creator'   => 'Пользователь',
            'date'      => 'Дата',
            'result'    => 'Результат',
        ],
        'hint'      => 'Результаты всех бросков.',
        'success'   => 'Кости брошены.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Результаты',
        ],
    ],
];
