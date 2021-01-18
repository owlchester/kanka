<?php

return [
    'create'        => [
        'description'   => 'Skapa en ny organisation',
        'success'       => 'Organisation \':name\' skapad.',
        'title'         => 'Ny Organisation',
    ],
    'destroy'       => [
        'success'   => 'Organisation \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Organisation \':name\' uppdaterad.',
        'title'     => 'Redigera Organisation :name',
    ],
    'fields'        => [
        'image'         => 'Bild',
        'location'      => 'Plats',
        'members'       => 'Medlemmar',
        'name'          => 'Namn',
        'organisation'  => 'Huvudorganisation',
        'organisations' => 'Underorganisation',
        'relation'      => 'Förbindelse',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Denna lista innehåller organisationer under denna organisation, och inte bara dem direkt under den.',
        'nested'        => 'I Hierarkisk Vy kan du se dina organisationer i hierarkisk ordning. Organisationer utan en huvudorganisation kommer visas som standard. Organisationer med underorganisationer kan klickas på för att visa dessa. Du kan fortsätta klicka tills det inte finns fler underorganisationer.',
    ],
    'index'         => [
        'add'           => 'Ny Organisation',
        'description'   => 'Hantera organisationerna för :name.',
        'header'        => 'Organisationer för :name',
        'title'         => 'Organisationer',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Lägg till en medlem',
        ],
        'create'        => [
            'description'   => 'Lägg till en medlem till organisationen',
            'success'       => 'Medlem tillagd till organisationen.',
            'title'         => 'Ny Organisationsmedlem för :name',
        ],
        'destroy'       => [
            'success'   => 'Medlem borttagen från organisationen.',
        ],
        'edit'          => [
            'success'   => 'Organisation medlem uppdaterad.',
            'title'     => 'Uppdatera Medlem för :name',
        ],
        'fields'        => [
            'character'     => 'Karaktär',
            'organisation'  => 'Organisation',
            'role'          => 'Roll',
        ],
        'helpers'       => [
            'all_members'   => 'Alla karaktärer som är medlemmar i denna organisation eller dess underorganisationer.',
            'members'       => 'Alla karaktärer som är medlemmar i denna organisationen.',
        ],
        'placeholders'  => [
            'character' => 'Välj en karaktär',
            'role'      => 'Ledare, Medlem, Överste Präst, Spionmästare',
        ],
        'title'         => 'Organisation :name Medlemmar',
    ],
    'organisations' => [
        'title' => 'Organisation :name Organisationer',
    ],
    'placeholders'  => [
        'location'  => 'Välj en plats',
        'name'      => 'Namn på organisationen',
        'type'      => 'Kult, Gäng, Rebellgrupp, Beundrarklubb',
    ],
    'quests'        => [
        'description'   => 'Uppdrag organisationen är en del av.',
        'title'         => 'Organisation :name Uppdrag',
    ],
    'show'          => [
        'description'   => 'En detaljerad vy för en organisation',
        'tabs'          => [
            'organisations' => 'Organisationer',
            'quests'        => 'Uppdrag',
            'relations'     => 'Förbindelser',
        ],
        'title'         => 'Organisation :name',
    ],
];
