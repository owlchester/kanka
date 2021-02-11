<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Stel een personage in voor een Quest',
            'success'       => 'Personage toegevoegd aan :name',
            'title'         => 'Nieuw Personage voor :name',
        ],
        'destroy'   => [
            'success'   => 'Quest personage voor :name verwijderd.',
        ],
        'edit'      => [
            'description'   => 'Werk een quest\'s personage bij',
            'success'       => 'Quest personage voor :name bijgewerkt.',
            'title'         => 'Werk personage bij voor :name',
        ],
        'fields'    => [
            'character'     => 'Personage',
            'description'   => 'Beschrijving',
        ],
        'title'     => 'Personages in :name',
    ],
    'create'        => [
        'description'   => 'Maak een nieuwe quest',
        'success'       => 'Quest \':name\' gemaakt.',
        'title'         => 'Nieuwe Quest',
    ],
    'destroy'       => [
        'success'   => 'Quest \':name\' verwijderd.',
    ],
    'edit'          => [
        'description'   => 'Bewerk een quest',
        'success'       => 'Quest \':name\' bijgewerkt.',
        'title'         => 'Quest :name bewerken',
    ],
    'fields'        => [
        'character'     => 'Aanstichter',
        'characters'    => 'Personages',
        'copy_elements' => 'Kopieer elementen die aan de quest zijn gekoppeld',
        'date'          => 'Datum',
        'description'   => 'Beschrijving',
        'image'         => 'Afbeelding',
        'is_completed'  => 'Voltooid',
        'items'         => 'Voorwerpen',
        'locations'     => 'Locaties',
        'name'          => 'Naam',
        'organisations' => 'Organisaties',
        'quest'         => 'Bovenliggende Quest',
        'quests'        => 'Sub Quest',
        'role'          => 'Rol',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'In geneste weergave kun je je Quests op een geneste manier bekijken. Quests zonder bovenliggende quest worden standaard weergegeven. Quests met sub quests kunnen worden aangeklikt om die gerelateerden te bekijken. Je kunt blijven klikken totdat er geen gerelateerden meer te zien zijn.',
    ],
    'hints'         => [
        'quests'    => 'Met het veld Bovenliggende Quest kan een web van in elkaar grijpende quests worden gebouwd.',
    ],
    'index'         => [
        'add'           => 'Nieuwe Quest',
        'description'   => 'Beheer de quests van :name.',
        'header'        => 'Quests van :name',
        'title'         => 'Quests',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Stel een voorwerp in op een Quest',
            'success'       => 'Voorwerp toegevoegd aan :name',
            'title'         => 'Nieuw Voorwerp voor :name',
        ],
        'destroy'   => [
            'success'   => 'Quest voorwerp voor :name verwijderd.',
        ],
        'edit'      => [
            'description'   => 'Werk het voorwerp van een quest bij',
            'success'       => 'Quest voorwerp voor :name bijgewerkt.',
            'title'         => 'Werk voorwerp bij voor :name',
        ],
        'fields'    => [
            'description'   => 'Beschrijving',
            'item'          => 'Voorwerp',
        ],
        'title'     => 'Voorwerpen in :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Stel een locatie in op een Quest',
            'success'       => 'Locatie toegevoegd aan :name.',
            'title'         => 'Nieuwe Locatie voor :name',
        ],
        'destroy'   => [
            'success'   => 'Quest locatie voor :name verwijderd.',
        ],
        'edit'      => [
            'description'   => 'Werk een quest\'s locatie bij',
            'success'       => 'Quest locatie voor :name bijgewerkt.',
            'title'         => 'Werk locatie bij voor :name',
        ],
        'fields'    => [
            'description'   => 'Beschrijving',
            'location'      => 'Locatie',
        ],
        'title'     => 'Locaties in :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Stel een organisatie in op een Quest',
            'success'       => 'Organisatie toegevoegd aan :name.',
            'title'         => 'Nieuwe Organisatie voor :name',
        ],
        'destroy'   => [
            'success'   => 'Quest organisatie voor :name verwijderd.',
        ],
        'edit'      => [
            'description'   => 'Werk een quest\'s organisatie bij',
            'success'       => 'Quest organisatie voor :name bijgewerkt.',
            'title'         => 'Werk een organisatie bij voor :name',
        ],
        'fields'    => [
            'description'   => 'Beschrijving',
            'organisation'  => 'Organisatie',
        ],
        'title'     => 'Organisaties in :name',
    ],
    'placeholders'  => [
        'date'  => 'Echte werelddatum voor de quest',
        'name'  => 'Naam van de quest',
        'quest' => 'Bovenliggende Quest',
        'role'  => 'De rol van deze entiteit in de quest',
        'type'  => 'Karakter Boog, Sidequest, Hoofd',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Voeg een personage toe',
            'add_item'          => 'Voeg een voorwerp toe',
            'add_location'      => 'Voeg een locatie toe',
            'add_organisation'  => 'Voeg een organisatie toe',
        ],
        'description'   => 'Een gedetailleerd overzicht van een quest',
        'tabs'          => [
            'characters'    => 'Personages',
            'information'   => 'Informatie',
            'items'         => 'Voorwerpen',
            'locations'     => 'Locaties',
            'organisations' => 'Organisaties',
            'quests'        => 'Quests',
        ],
        'title'         => 'Quests :name',
    ],
];
