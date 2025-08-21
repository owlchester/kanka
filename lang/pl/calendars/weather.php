<?php

return [
    'actions'       => [],
    'create'        => [
        'helper'    => 'Dodaj informację o pogodzie, która pojawi się w kalendarzu.',
        'success'   => 'Dodano pogodę.',
        'title'     => 'Nowy efekt pogody',
    ],
    'destroy'       => [
        'success'   => 'Usunięto pogodę.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono pogodę.',
        'title'     => 'Zmiana pogody',
    ],
    'fields'        => [
        'effect'        => 'Efekt',
        'name'          => 'Nazwa',
        'precipitation' => 'Opady',
        'temperature'   => 'Temperatura',
        'weather'       => 'Pogoda',
        'wind'          => 'Wiatr',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Burza z piorunami',
            'cloud'                 => 'Pochmurno',
            'cloud-rain'            => 'Deszczowo',
            'cloud-showers-heavy'   => 'Ulewa',
            'cloud-sun'             => 'Słonecznie i pochmurno',
            'cloud-sun-rain'        => 'Słonecznie, pochmurno i deszczowo',
            'meteor'                => 'Meteor',
            'smog'                  => 'Smog',
            'snowflake'             => 'Śnieżnie',
            'sun'                   => 'Słonecznie',
            'wind'                  => 'Wietrznie',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Efekt magiczny lub naturalny',
        'name'          => 'Opcjonalna nazwa pogody',
        'precipitation' => 'Intensywność opadów',
        'temperature'   => 'Najwyższa i najniższa',
        'wind'          => 'Prędkość wiatru',
    ],
];
