<?php

return [
    'actions'       => [
        'delete-confirm' => 'this weather',
    ],
    'create'        => [
        'success'   => 'Weather added.',
        'title'     => 'New weather',
    ],
    'destroy'       => [
        'success'   => 'Weather removed.',
    ],
    'edit'          => [
        'success'   => 'Weather updated.',
        'title'     => 'Update Weather',
    ],
    'fields'        => [
        'effect'        => 'Effect',
        'name'          => 'Name',
        'precipitation' => 'Precipitation',
        'temperature'   => 'Temperature',
        'weather'       => 'Weather',
        'wind'          => 'Wind',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Thunder',
            'cloud'                 => 'Cloudy',
            'cloud-rain'            => 'Rainy',
            'cloud-showers-heavy'   => 'Heavy Rain',
            'cloud-sun'             => 'Cloudy and Sunny',
            'cloud-sun-rain'        => 'Cloud, Sun and Rain',
            'meteor'                => 'Meteor',
            'smog'                  => 'Smog',
            'snowflake'             => 'Snow',
            'sun'                   => 'Sunny',
            'wind'                  => 'Windy',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Magical or natural effect',
        'name'          => 'Optional custom weather text',
        'precipitation' => 'Amount of water',
        'temperature'   => 'Daily high and low',
        'wind'          => 'Wind speeds',
    ],
];
