<?php

return [
    'create'        => [
        'success'   => 'Dodani vremenski uvjeti.',
        'title'     => 'Novi učinak vremenskih uvjeta',
    ],
    'destroy'       => [
        'success'   => 'Uklonjeni vremenski uvjeti.',
    ],
    'edit'          => [
        'success'   => 'Ažurirani vremenski uvjeti.',
        'title'     => 'Ažuriraj vremenske uvjete',
    ],
    'fields'        => [
        'effect'        => 'Učinak',
        'name'          => 'Naziv',
        'precipitation' => 'Oborine',
        'temperature'   => 'Temperatura',
        'weather'       => 'Vremenski uvjeti',
        'wind'          => 'Vjetar',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Grmljavina',
            'cloud'                 => 'Oblačno',
            'cloud-rain'            => 'Kišovito',
            'cloud-showers-heavy'   => 'Jaka kiša',
            'cloud-sun'             => 'Oblačno i sunčano',
            'cloud-sun-rain'        => 'Oblaci, sunčano i kiša',
            'meteor'                => 'Meteor',
            'smog'                  => 'Smog',
            'snowflake'             => 'Snijeg',
            'sun'                   => 'Sunčano',
            'wind'                  => 'Vjetrovito',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Magični ili prirodni učinak',
        'name'          => 'Neobavezan prilagođeni tekst o vremenu',
        'precipitation' => 'Količina vode',
        'temperature'   => 'Dnevno visoka i niska',
        'wind'          => 'Brzine vjetra',
    ],
];
