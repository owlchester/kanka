<?php

return [
    'create'        => [
        'success'   => 'Météo ajoutée.',
        'title'     => 'Nouveau effet météorologique',
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
        'precipitation' => 'Précipidation',
        'temperature'   => 'Température',
        'weather'       => 'Météo',
        'wind'          => 'Vent',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Eclaire',
            'cloud'                 => 'Nuageux',
            'cloud-rain'            => 'Pluie',
            'cloud-showers-heavy'   => 'Forte Pluie',
            'cloud-sun'             => 'Nuage et soleil',
            'cloud-sun-rain'        => 'Nuage, soleil et pluie',
            'meteor'                => 'Météorite',
            'smog'                  => 'Brouillard',
            'snowflake'             => 'Neige',
            'sun'                   => 'Soleilleux',
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
