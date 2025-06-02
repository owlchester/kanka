<?php

return [
    'create'        => [
        'helper'    => 'Ajouter des informations météo à apparaître sur le calendrier.',
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
        'name'          => 'Nom',
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
        'name'          => 'Text optionnel pour l\'effet météorologique',
        'precipitation' => 'Quantité de pluie',
        'temperature'   => 'Quotidien haut et bas',
        'wind'          => 'Force du vent',
    ],
];
