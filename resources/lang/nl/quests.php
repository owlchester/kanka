<?php

return [
    'create'        => [
        'success'       => 'Quest \':name\' gemaakt.',
        'title'         => 'Nieuwe Quest',
    ],
    'destroy'       => [
        'success'   => 'Quest \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'       => 'Quest \':name\' bijgewerkt.',
        'title'         => 'Quest :name bewerken',
    ],
    'fields'        => [
        'character'     => 'Aanstichter',
        'copy_elements' => 'Kopieer elementen die aan de quest zijn gekoppeld',
        'date'          => 'Datum',
        'description'   => 'Beschrijving',
        'image'         => 'Afbeelding',
        'is_completed'  => 'Voltooid',
        'name'          => 'Naam',
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
        'header'        => 'Quests van :name',
        'title'         => 'Quests',
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
        ],
        'tabs'          => [
            'information'   => 'Informatie',
            'quests'        => 'Quests',
        ],
        'title'         => 'Quests :name',
    ],
];
