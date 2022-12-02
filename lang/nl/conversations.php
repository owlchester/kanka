<?php

return [
    'create'        => [
        'title' => 'Nieuwe Conversatie',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Conversatie :name',
    ],
    'fields'        => [
        'messages'      => 'Berichten',
        'participants'  => 'Deelnemers',
    ],
    'hints'         => [
        'participants'  => 'Voeg deelnemers aan je conversatie toe door op het :icon pictogram in de rechterbovenhoek te drukken.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Bericht verwijderd.',
        ],
        'is_updated'    => 'Bijgewerkt',
        'load_previous' => 'Laad vorige berichten',
        'placeholders'  => [
            'message'   => 'Jouw berichten',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Deelnemer :entity toegevoegd aan de conversatie.',
        ],
        'destroy'   => [
            'success'   => 'Deelnemer :entity verwijderd uit de conversatie.',
        ],
        'modal'     => 'Deelnemers',
        'title'     => 'Deelnemers van :name',
    ],
    'placeholders'  => [
        'name'  => 'Naam van de conversatie',
        'type'  => 'In Game, Prep, Plot',
    ],
    'show'          => [],
    'tabs'          => [
        'conversation'  => 'Conversatie',
        'participants'  => 'Deelnemers',
    ],
    'targets'       => [
        'characters'    => 'Personages',
        'members'       => 'Leden',
    ],
];
