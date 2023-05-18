<?php

return [
    'create'        => [
        'title' => 'Nieuwe Familie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Leden',
    ],
    'helpers'       => [
        'descendants'   => 'Deze lijst bevat alle families die afstammen van deze familie, en niet alleen de families er direct onder.',
    ],
    'hints'         => [
        'members'   => 'Leden van een familie worden hier vermeld. Een personage kan aan een familie worden toegevoegd door het gewenste personage te bewerken en de vervolgkeuzelijst "Familie" te gebruiken.',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'De volgende lijst bevat alle personages die in deze familie voorkomen en alle afstammelingen van de familie.',
            'direct_members'    => 'De meeste families hebben leden die het runnen of het beroemd hebben gemaakt. De volgende lijst bevat personages die direct in deze familie voorkomen.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Naam van de familie',
        'type'  => 'Koninklijk, Adel, Uitgestorven',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Leden',
        ],
    ],
];
