<?php

return [
    'create'        => [
        'success'   => 'Погоду додано.',
        'title'     => 'Нова погода',
    ],
    'destroy'       => [
        'success'   => 'Погоду видалено.',
    ],
    'edit'          => [
        'success'   => 'Погоду оновлено.',
        'title'     => 'Оновити погоду',
    ],
    'fields'        => [
        'effect'        => 'Ефект',
        'name'          => 'Назва',
        'precipitation' => 'Опади',
        'temperature'   => 'Температура',
        'weather'       => 'Погода',
        'wind'          => 'Вітер',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Гроза',
            'cloud'                 => 'Хмарно',
            'cloud-rain'            => 'Дощить',
            'cloud-showers-heavy'   => 'Сильний дощ',
            'cloud-sun'             => 'Хмарно і сонячно',
            'cloud-sun-rain'        => 'Хмарно, сонце і дощ',
            'meteor'                => 'Метеор',
            'smog'                  => 'Смог',
            'snowflake'             => 'Сніг',
            'sun'                   => 'Сонячно',
            'wind'                  => 'Вітряно',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Магічний або природний ефект',
        'name'          => 'Необов\'язковий довільний погодний текст',
        'precipitation' => 'Кількість води',
        'temperature'   => 'Щоденні припливи й відпливи',
        'wind'          => 'Швидкість вітру',
    ],
];
