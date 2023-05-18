<?php

return [
    'create'        => [
        'title' => 'Nieuwe Quest',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character'     => 'Aanstichter',
        'copy_elements' => 'Kopieer elementen die aan de quest zijn gekoppeld',
        'date'          => 'Datum',
        'is_completed'  => 'Voltooid',
        'role'          => 'Rol',
    ],
    'helpers'       => [],
    'hints'         => [
        'quests'    => 'Met het veld Bovenliggende Quest kan een web van in elkaar grijpende quests worden gebouwd.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Echte werelddatum voor de quest',
        'role'  => 'De rol van deze entiteit in de quest',
        'type'  => 'Karakter Boog, Sidequest, Hoofd',
    ],
    'show'          => [],
];
