<?php

return [
    'actions'       => [],
    'create'        => [
        'helper'    => 'Füge Wetterinformationen hinzu, die im Kalender angezeigt werden sollen.',
        'success'   => 'Wetter hinzugefügt.',
        'title'     => 'Neuer Wettereffekt',
    ],
    'destroy'       => [
        'success'   => 'Wetter entfernt',
    ],
    'edit'          => [
        'success'   => 'Wetter aktualisiert',
        'title'     => 'Wetter aktualisieren',
    ],
    'fields'        => [
        'effect'        => 'Effekt',
        'name'          => 'Name',
        'precipitation' => 'Niederschlag',
        'temperature'   => 'Temperatur',
        'weather'       => 'Wetter',
        'wind'          => 'Wind',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Donner',
            'cloud'                 => 'Wolkig',
            'cloud-rain'            => 'Regnerisch',
            'cloud-showers-heavy'   => 'Starkregen',
            'cloud-sun'             => 'Bewölkt und sonnig',
            'cloud-sun-rain'        => 'Wolke, Sonne und Regen',
            'meteor'                => 'Meteor',
            'smog'                  => 'Smog',
            'snowflake'             => 'Schnee',
            'sun'                   => 'Sonnig',
            'wind'                  => 'Windig',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Magische oder natürliche Wirkung',
        'name'          => 'Optionaler benutzerdefinierter Wettertext',
        'precipitation' => 'Wassermenge',
        'temperature'   => 'Täglich hoch und niedrig',
        'wind'          => 'Windgeschwindigkeit',
    ],
];
