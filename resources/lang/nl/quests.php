<?php

return [
    'create'        => [
        'success'   => 'Quest \':name\' gemaakt.',
        'title'     => 'Nieuwe Quest',
    ],
    'destroy'       => [
        'success'   => 'Quest \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Quest \':name\' bijgewerkt.',
        'title'     => 'Quest :name bewerken',
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
    'helpers'       => [],
    'hints'         => [
        'quests'    => 'Met het veld Bovenliggende Quest kan een web van in elkaar grijpende quests worden gebouwd.',
    ],
    'index'         => [
        'add'       => 'Nieuwe Quest',
        'header'    => 'Quests van :name',
        'title'     => 'Quests',
    ],
    'placeholders'  => [
        'date'  => 'Echte werelddatum voor de quest',
        'name'  => 'Naam van de quest',
        'quest' => 'Bovenliggende Quest',
        'role'  => 'De rol van deze entiteit in de quest',
        'type'  => 'Karakter Boog, Sidequest, Hoofd',
    ],
    'show'          => [
        'title' => 'Quests :name',
    ],
];
