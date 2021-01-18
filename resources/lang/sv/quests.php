<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Lägg till en karaktär till ett Uppdrag',
            'success'       => 'Karaktär tillagd till :name.',
            'title'         => 'Ny Karaktär för :name',
        ],
        'destroy'   => [
            'success'   => 'Uppdrags karaktär för :name borttagen.',
        ],
        'edit'      => [
            'description'   => 'Uppdatera ett uppdrags karaktär',
            'success'       => 'Uppdrags karaktär för :name uppdaterad.',
            'title'         => 'Uppdatera karaktär för :name',
        ],
        'fields'    => [
            'character'     => 'Karaktär',
            'description'   => 'Beskrivning',
        ],
        'title'     => 'Karaktärer i :name',
    ],
    'create'        => [
        'description'   => 'Skapa ett nytt uppdrag',
        'success'       => 'Uppdrag \':name\' skapat.',
        'title'         => 'Nytt Uppdrag',
    ],
    'destroy'       => [
        'success'   => 'Uppdrag \':name\' borttaget.',
    ],
    'edit'          => [
        'description'   => 'Redigera ett uppdrag',
        'success'       => 'Uppdrag \':name\' uppdaterat.',
        'title'         => 'Redigera Uppdrag :name',
    ],
    'fields'        => [
        'character'     => 'Anstiftare',
        'characters'    => 'Karaktärer',
        'copy_elements' => 'Kopiera element fästa till uppdraget',
        'date'          => 'Datum',
        'description'   => 'Beskrivning',
        'image'         => 'Bild',
        'is_completed'  => 'Avslutat',
        'items'         => 'Föremål',
        'locations'     => 'Platser',
        'name'          => 'Namn',
        'organisations' => 'Organisationer',
        'quest'         => 'Huvuduppdrag',
        'quests'        => 'Underuppdrag',
        'role'          => 'Roll',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'I Hierarkisk Vy kan du se dina uppdrag i hierarkisk ordning. Uppdrag utan ett huvuduppdrag kommer visas som standard. Uppdrag med underuppdrag kan klickas på för att visa dessa. Du kan fortsätta klicka tills det inte finns fler underuppdrag.',
    ],
    'hints'         => [
        'quests'    => 'Ett nätt av sammankopplade uppdrag kan byggas genom att använda Huvuduppdrag fältet.',
    ],
    'index'         => [
        'add'           => 'Nytt Uppdrag',
        'description'   => 'Hantera uppdrag för :name',
        'header'        => 'Uppdrag för :name',
        'title'         => 'Uppdrag',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Lägg till ett föremål till ett Uppdrag',
            'success'       => 'Föremål tillagt till :name',
            'title'         => 'Nytt Föremål för :name',
        ],
        'destroy'   => [
            'success'   => 'Uppdragsföremål för :name borttaget.',
        ],
        'edit'      => [
            'description'   => 'Uppdatera ett uppdragsföremål',
            'success'       => 'Uppdrags föremål för :name uppdaterat.',
            'title'         => 'Uppdatera föremål för :name',
        ],
        'fields'    => [
            'description'   => 'Beskrivning',
            'item'          => 'Föremål',
        ],
        'title'     => 'Föremål i :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Lägg till en plats till ett Uppdrag',
            'success'       => 'Plats tillagd till :name.',
            'title'         => 'Ny Plats för :name',
        ],
        'destroy'   => [
            'success'   => 'Uppdragsplats för :name borttagen.',
        ],
        'edit'      => [
            'description'   => 'Uppdatera ett uppdrags plats.',
            'success'       => 'Uppdragsplats för :name uppdaterad.',
            'title'         => 'Uppdatera plats för :name',
        ],
        'fields'    => [
            'description'   => 'Beskrivning',
            'location'      => 'Plats',
        ],
        'title'     => 'Platser i :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Lägg till en organisation till ett Uppdrag',
            'success'       => 'Organisation tillagd till :name.',
            'title'         => 'Ny Organisation för :name',
        ],
        'destroy'   => [
            'success'   => 'Uppdragsorganisation för :name borttagen.',
        ],
        'edit'      => [
            'description'   => 'Uppdatera ett uppdrags organisation.',
            'success'       => 'Uppdragsorganisation för :name uppdaterad.',
            'title'         => 'Uppdatera organisation för :name',
        ],
        'fields'    => [
            'description'   => 'Beskrivning',
            'organisation'  => 'Organisation',
        ],
        'title'     => 'Organisationer i :name',
    ],
    'placeholders'  => [
        'date'  => 'Verklig världs datum för uppdraget',
        'name'  => 'Namn på uppdraget',
        'quest' => 'Huvuduppdrag',
        'role'  => 'Denna entitets roll i uppdraget',
        'type'  => 'Karaktärsark, Sidouppdrag, Primärt',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Lägg till en karaktär',
            'add_item'          => 'Lägg till ett föremål',
            'add_location'      => 'Lägg till en plats',
            'add_organisation'  => 'Lägg till en organisation',
        ],
        'description'   => 'En detaljerat vy av ett uppdrag',
        'tabs'          => [
            'characters'    => 'Karaktärer',
            'information'   => 'Information',
            'items'         => 'Föremål',
            'locations'     => 'Platser',
            'organisations' => 'Organisationer',
            'quests'        => 'Uppdrag',
        ],
        'title'         => 'Uppdrag :name',
    ],
];
