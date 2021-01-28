<?php

return [
    'characters'    => [
        'description'   => 'Personages die bij het ras horen.',
        'helpers'       => [
            'all_characters'    => 'Alle personages weergeven die verband houden met dit ras en zijn sub rassen.',
            'characters'        => 'Alle personages weergeven die rechtstreeks verband houden met dit ras.',
        ],
        'title'         => 'Ras :name Personages',
    ],
    'create'        => [
        'description'   => 'Maak een nieuw ras',
        'success'       => 'Ras \':name\' gemaakt.',
        'title'         => 'Nieuw Ras',
    ],
    'destroy'       => [
        'success'   => 'Ras \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Ras \':name\' bijgewerkt.',
        'title'     => 'Wijzig Ras :name',
    ],
    'fields'        => [
        'characters'    => 'Personages',
        'name'          => 'Naam',
        'race'          => 'Bovenliggend Ras',
        'races'         => 'Sub Rassen',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'In geneste weergave kun je je rassen op een geneste manier bekijken. Rassen zonder bovenliggend ras worden standaard weergegeven. Op rassen met sub rassen kan worden geklikt om die gerelateerden te bekijken. Je kunt blijven klikken totdat er geen gerelateerden meer te zien zijn.',
    ],
    'index'         => [
        'add'           => 'Nieuw Ras',
        'description'   => 'Beheer de rassen van :name',
        'header'        => 'Rassen van :name',
        'title'         => 'Rassen',
    ],
    'placeholders'  => [
        'name'  => 'Naam van het ras',
        'type'  => 'Mens, Fey, Borg',
    ],
    'races'         => [
        'description'   => 'Rassen die bij het ras horen.',
        'title'         => 'Ras :name Subrassen',
    ],
    'show'          => [
        'description'   => 'Een gedetailleerd overzicht van een ras',
        'tabs'          => [
            'characters'    => 'Personages',
            'menu'          => 'Menu',
            'races'         => 'Subrassen',
        ],
        'title'         => 'Ras :name',
    ],
];
