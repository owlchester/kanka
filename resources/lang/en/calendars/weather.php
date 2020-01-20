<?php

return [
    'create' => [
        'title' => 'New Weather Effect',
        'success' => 'Weather added.',
    ],
    'destroy' => [
        'success' => 'Weather removed.',
    ],
    'fields' => [
        'weather' => 'Weather',
        'temperature' => 'Temperature',
        'precipitation' => 'Precipitation',
        'wind' => 'Wind',
        'effect' => 'Effect',
    ],
    'placeholders' => [
        'temperature' => 'Daily high and low',
        'precipitation' => 'Amount of water',
        'wind' => 'Wind speeds',
        'effect' => 'Magical or natural effect'
    ],
    'options' => [
        'weather' => [
            'cloud' => 'Cloudy',
            'smog' => 'Smog',
            'wind' => 'Windy',
            'bolt' => 'Thunder',
            'sun' => 'Sunny',
            'cloud-sun' => 'Cloudy and Sunny',
            'cloud-sun-rain' => 'Cloud, Sun and Rain',
            'cloud-showers-heavy' => 'Heavy Rain',
            'cloud-rain' => 'Rainy',
            'meteor' => 'Meteor',
            'snowflake' => 'Snow',
        ]
    ],
    'edit' => [
        'title' => 'Update Weather',
        'success' => 'Weather updated.',
    ]
];
