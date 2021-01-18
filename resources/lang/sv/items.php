<?php

return [
    'create'        => [
        'description'   => 'Skapa ett nytt föremål',
        'success'       => 'Föremål \':name\' skapat.',
        'title'         => 'Nytt Föremål',
    ],
    'destroy'       => [
        'success'   => 'Föremål \':name\' borttaget.',
    ],
    'edit'          => [
        'success'   => 'Föremål \':name\' uppdaterat.',
        'title'     => 'Redigera Föremål :name',
    ],
    'fields'        => [
        'character' => 'Karaktär',
        'image'     => 'Bild',
        'location'  => 'Plats',
        'name'      => 'Namn',
        'price'     => 'Pris',
        'relation'  => 'Förbindelse',
        'size'      => 'Storlek',
        'type'      => 'Typ',
    ],
    'index'         => [
        'add'           => 'Nytt Föremål',
        'description'   => 'Hantera föremålen för :name.',
        'header'        => 'Föremål för :name',
        'title'         => 'Föremål',
    ],
    'inventories'   => [
        'description'   => 'Entitets Inventarier föremålet finns i.',
        'title'         => 'Föremål :name Inventarier',
    ],
    'placeholders'  => [
        'character' => 'Välj en karaktär',
        'location'  => 'Välj en plats',
        'name'      => 'Namn på föremålet',
        'price'     => 'Pris på föremålet',
        'size'      => 'Storlek, Vikt, Dimensioner',
        'type'      => 'Vapen, Trolldryck, Artefakt',
    ],
    'quests'        => [
        'description'   => 'Uppdrag föremålet är en del av.',
        'title'         => 'Föremål :name Uppdrag',
    ],
    'show'          => [
        'description'   => 'En detaljerad vy för ett föremål',
        'tabs'          => [
            'information'   => 'Information',
            'inventories'   => 'Inventarier',
            'quests'        => 'Uppdrag',
        ],
        'title'         => 'Föremål :name',
    ],
];
