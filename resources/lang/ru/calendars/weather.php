<?php

return [
    'create'        => [
        'success'   => 'Погода добавлена.',
        'title'     => 'Новый эффект погоды',
    ],
    'destroy'       => [
        'success'   => 'Погода удалена.',
    ],
    'edit'          => [
        'success'   => 'Погода обновлена.',
        'title'     => 'Обновление погоды',
    ],
    'fields'        => [
        'effect'        => 'Эффект',
        'precipitation' => 'Осадки',
        'temperature'   => 'Температура',
        'weather'       => 'Погода',
        'wind'          => 'Ветер',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Гром',
            'cloud'                 => 'Облачно',
            'cloud-rain'            => 'Дождь',
            'cloud-showers-heavy'   => 'Ливень',
            'cloud-sun'             => 'Облачно и ясно',
            'cloud-sun-rain'        => 'Облачно, солнце и дождь',
            'meteor'                => 'Метеорит',
            'smog'                  => 'Смог',
            'snowflake'             => 'Снег',
            'sun'                   => 'Солнечно',
            'wind'                  => 'Ветрено',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Магический или природный эффект',
        'precipitation' => 'Объем воды',
        'temperature'   => 'Дневной максимум и минимум',
        'wind'          => 'Скорость ветра',
    ],
];
