<?php

return [
    'create'        => [
        'success'   => 'Погода добавлена',
        'title'     => 'Новое погодное явление',
    ],
    'destroy'       => [
        'success'   => 'Погода удалена',
    ],
    'edit'          => [
        'success'   => 'Погода обновлена',
        'title'     => 'Обновление погоды',
    ],
    'fields'        => [
        'effect'        => 'Погодное явление',
        'precipitation' => 'Осадки',
        'temperature'   => 'Температура',
        'weather'       => 'Погода',
        'wind'          => 'Ветер',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Гром',
            'cloud'                 => 'Облака',
            'cloud-rain'            => 'Дождь',
            'cloud-showers-heavy'   => 'Ливень',
            'cloud-sun'             => 'Облака и солнце',
            'cloud-sun-rain'        => 'Облака, дождь и солнце',
            'meteor'                => 'Метеорит',
            'smog'                  => 'Смог',
            'snowflake'             => 'Снег',
            'sun'                   => 'Солнце',
            'wind'                  => 'Ветер',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Магическое или природное явление',
        'precipitation' => 'Объем воды',
        'temperature'   => 'Дневной максимум и минимум',
        'wind'          => 'Скорость ветра',
    ],
];
