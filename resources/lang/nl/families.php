<?php

return [
    'create'        => [
        'description'   => 'Maak een nieuwe familie',
        'success'       => 'Familie \':name\' gemaakt.',
        'title'         => 'Nieuwe Familie',
    ],
    'destroy'       => [
        'success'   => 'Familie \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Familie \':name\' bijgewerkt.',
        'title'     => 'Wijzig Familie :name',
    ],
    'families'      => [
        'title' => 'Familie :name Families',
    ],
    'fields'        => [
        'families'  => 'Sub Families',
        'family'    => 'Bovenliggende Familie',
        'image'     => 'Afbeelding',
        'location'  => 'Locatie',
        'members'   => 'Leden',
        'name'      => 'Naam',
        'relation'  => 'Relatie',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Deze lijst bevat alle families die afstammen van deze familie, en niet alleen de families er direct onder.',
        'nested'        => 'In geneste weergave kunt je jouw families op een geneste manier bekijken. Families zonder bovenliggende familie worden standaard weergegeven. Op families met sub families kan worden geklikt om die gerelateerden te bekijken. Je kunt blijven klikken totdat er geen gerelateerden meer te zien zijn.',
    ],
    'hints'         => [
        'members'   => 'Leden van een familie worden hier vermeld. Een personage kan aan een familie worden toegevoegd door het gewenste personage te bewerken en de vervolgkeuzelijst "Familie" te gebruiken.',
    ],
    'index'         => [
        'add'           => 'Nieuwe Familie',
        'description'   => 'Beheer de families van :name.',
        'header'        => 'Families van :name',
        'title'         => 'Families',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'De volgende lijst bevat alle personages die in deze familie voorkomen en alle afstammelingen van de familie.',
            'direct_members'    => 'De meeste families hebben leden die het runnen of het beroemd hebben gemaakt. De volgende lijst bevat personages die direct in deze familie voorkomen.',
        ],
        'title'     => 'Family :name Leden',
    ],
    'placeholders'  => [
        'location'  => 'Kies een locatie',
        'name'      => 'Naam van de familie',
        'type'      => 'Koninklijk, Adel, Uitgestorven',
    ],
    'show'          => [
        'description'   => 'Een gedetailleerd overzicht van een familie',
        'tabs'          => [
            'all_members'   => 'Alle Leden',
            'families'      => 'Families',
            'members'       => 'Leden',
            'relation'      => 'Relaties',
        ],
        'title'         => 'Familie :name',
    ],
];
