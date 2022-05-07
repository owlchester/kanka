<?php

return [
    'create'        => [
        'success'   => 'Organisation \':name\' skapad.',
        'title'     => 'Ny Organisation',
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
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Denna lista innehåller organisationer under denna organisation, och inte bara dem direkt under den.',
    ],
    'index'         => [
        'title' => 'Organisationer',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Lägg till en medlem',
        ],
        'create'        => [
            'success'   => 'Medlem tillagd till organisationen.',
            'title'     => 'Ny Organisationsmedlem för :name',
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
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organisationer',
        ],
    ],
];
