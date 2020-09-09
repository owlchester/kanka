<?php

return [
    'create'        => [
        'success'   => 'Météo ajoutée.',
        'title'     => 'Nouvel effet météorologique',
    ],
    'destroy'       => [
        'success'   => 'Météo supprimée.',
    ],
    'edit'          => [
        'success'   => 'Météo modifiée.',
        'title'     => 'Modifier la météo',
    ],
    'fields'        => [
        'effect'        => 'Effet',
        'precipitation' => 'Précipitation',
        'temperature'   => 'Température',
        'weather'       => 'Météo',
        'wind'          => 'Vent',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Orage',
            'cloud'                 => 'Nuageux',
            'cloud-rain'            => 'Pluie',
            'cloud-showers-heavy'   => 'Forte Pluie',
            'cloud-sun'             => 'Nuage et soleil',
            'cloud-sun-rain'        => 'Nuage, soleil et pluie',
            'meteor'                => 'Météorite',
            'smog'                  => 'Brouillard',
            'snowflake'             => 'Neige',
            'sun'                   => 'Ensoleillé',
            'wind'                  => 'Venteux',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Effet magique ou naturel',
        'precipitation' => 'Quantité de pluie',
        'temperature'   => 'Quotidien haut et bas',
        'wind'          => 'Force du vent',
    ],
];
