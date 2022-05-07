<?php

return [
    'create'        => [
        'success'   => 'Organisatie \':name\' gemaakt.',
        'title'     => 'Nieuwe Organisatie',
    ],
    'destroy'       => [
        'success'   => 'Organisatie \':name\' verwijderd',
    ],
    'edit'          => [
        'success'   => 'Organisatie \':name\' bijgewerkt.',
        'title'     => 'Wijzig Organisatie :name',
    ],
    'fields'        => [
        'image'         => 'Afbeelding',
        'location'      => 'Locatie',
        'members'       => 'Leden',
        'name'          => 'Naam',
        'organisation'  => 'Bovenliggende Organisatie',
        'organisations' => 'Sub Organisaties',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Deze lijst bevat alle organisaties die afstammen van deze organisatie, en niet alleen de direct daaronder vallende organisaties.',
    ],
    'index'         => [
        'title' => 'Organisaties',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Voeg een lid toe',
        ],
        'create'        => [
            'success'   => 'Lid toegevoegd aan de organisatie.',
            'title'     => 'Nieuw Organisatie Lid voor :name',
        ],
        'destroy'       => [
            'success'   => 'Lid verwijderd van de organisatie',
        ],
        'edit'          => [
            'success'   => 'Organisatie lid bijgewerkt.',
            'title'     => 'Werk Lid bij voor :name',
        ],
        'fields'        => [
            'character'     => 'Personage',
            'organisation'  => 'Organisatie',
            'role'          => 'Rol',
        ],
        'helpers'       => [
            'all_members'   => 'Alle personages die lid zijn van deze organisaties en zijn suborganisaties.',
            'members'       => 'Alle personages die lid zijn van deze organisatie.',
        ],
        'placeholders'  => [
            'character' => 'Kies een personage',
            'role'      => 'Leider, Lid, Hoog-lid, Spymaster',
        ],
        'title'         => 'Organisatie :name Leden',
    ],
    'organisations' => [
        'title' => 'Organisatie :name Organisaties',
    ],
    'placeholders'  => [
        'location'  => 'Kies een locatie',
        'name'      => 'Naam van de organisatie',
        'type'      => 'Sekte, Gang, Rebellie, Fandom',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organisaties',
        ],
    ],
];
