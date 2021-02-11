<?php

return [
    'create'        => [
        'description'   => 'Maak een nieuw voorwerp',
        'success'       => 'Voorwerp \':name\' gemaakt.',
        'title'         => 'Nieuw Voorwerp',
    ],
    'destroy'       => [
        'success'   => 'Voorwerp \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Voorwerp \':name\' bijgewerkt.',
        'title'     => 'Wijzig Voorwerp :name',
    ],
    'fields'        => [
        'character' => 'Personage',
        'image'     => 'Afbeelding',
        'location'  => 'Locatie',
        'name'      => 'Naam',
        'price'     => 'Prijs',
        'relation'  => 'Relatie',
        'size'      => 'Grootte',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'Nieuw Voorwerp',
        'description'   => 'Beheer de voorwerpen van :name',
        'header'        => 'Voorwerpen van :name',
        'title'         => 'Voorwerpen',
    ],
    'inventories'   => [
        'description'   => 'Entiteits Inventories waarin het voorwerp zich bevindt.',
        'title'         => 'Voorwerp :name Inventories',
    ],
    'placeholders'  => [
        'character' => 'Kies een personage',
        'location'  => 'Kies een locatie',
        'name'      => 'Naam van het voorwerp',
        'price'     => 'Prijs van het voorwerp',
        'size'      => 'Grootte, Gewicht, Afmeting',
        'type'      => 'Wapen, Potion, Artefact',
    ],
    'quests'        => [
        'description'   => 'Quests waarvan het item deel van uitmaakt.',
        'title'         => 'Voorwerp :name Quests',
    ],
    'show'          => [
        'description'   => 'Een gedetailleerd overzicht van een voorwerp',
        'tabs'          => [
            'information'   => 'Informatie',
            'inventories'   => 'Inventories',
            'quests'        => 'Quests',
        ],
        'title'         => 'Voorwerp :name',
    ],
];
