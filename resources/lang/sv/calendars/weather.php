<?php

return [
    'create'        => [
        'success'   => 'Väder tillagt.',
        'title'     => 'Ny Väder effekt',
    ],
    'destroy'       => [
        'success'   => 'Väder borttaget.',
    ],
    'edit'          => [
        'success'   => 'Väder uppdaterat.',
        'title'     => 'Uppdatera Väder',
    ],
    'fields'        => [
        'effect'        => 'Effekt',
        'name'          => 'Namn',
        'precipitation' => 'Nederbörd',
        'temperature'   => 'Temperatur',
        'weather'       => 'Väder',
        'wind'          => 'Vind',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Åska',
            'cloud'                 => 'Molnigt',
            'cloud-rain'            => 'Regnigt',
            'cloud-showers-heavy'   => 'Kraftigt Regn',
            'cloud-sun'             => 'Växlande Molnighet',
            'cloud-sun-rain'        => 'Moln, Sol och Regn',
            'meteor'                => 'Meteor',
            'smog'                  => 'Smog',
            'snowflake'             => 'Snö',
            'sun'                   => 'Soligt',
            'wind'                  => 'Blåsigt',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Magisk eller naturlig effekt',
        'name'          => 'Alternativ väder text',
        'precipitation' => 'Mängd vatten',
        'temperature'   => 'Daglig högsta och lägsta',
        'wind'          => 'Vindhastighet',
    ],
];
