<?php

return [
    'actions'       => [
        'follow'    => 'Volg',
        'join'      => 'Join',
        'unfollow'  => 'Ontvolg',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count Modules',
            'roles'     => ':count Rollen',
            'users'     => ':count Gebruikers',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Wijzig',
            'new'       => 'Nieuw Dashboard',
            'switch'    => 'Wissel naar dashboard',
        ],
        'boosted'       => ':boosted_campaigns kan aangepaste dashboards maken voor elk van de campaign rollen.',
        'create'        => [
            'success'   => 'Nieuw campaign dashboard :name gemaakt.',
            'title'     => 'Nieuw Campaign Dashboard',
        ],
        'custom'        => [
            'text'  => 'Je bewerkt momenteel het :name dashboard van de campaign.',
        ],
        'default'       => [
            'text'  => 'Je bewerkt momenteel het standaard dashboard van de campaign.',
            'title' => 'Standaard Dashboard',
        ],
        'delete'        => [
            'success'   => 'Dashboard :name verwijderd.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Kopieer widgets',
            'name'          => 'Dashboard naam',
            'visibility'    => 'Zichtbaarheid',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Dupliceer de widgets van het :name dashboard naar deze nieuwe.',
        ],
        'placeholders'  => [
            'name'  => 'Naam van het dashboard',
        ],
        'update'        => [
            'success'   => 'Campaign dashboard :name bijgewerkt.',
            'title'     => 'Werk campaign dashboard :name bij',
        ],
        'visibility'    => [
            'default'   => 'Standaard',
            'none'      => 'Geen',
            'visible'   => 'Zichtbaar',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Als je een campaign volgt, wordt deze weergegeven in de campaign wisselaar (linksboven) onder je campaigns.',
        'join'      => 'Deze campaign staat open voor nieuwe leden. Klik om aan te vragen om er lid van te worden.',
        'setup'     => 'Stel het dashboard van je campaign in.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Begrepen',
            'title'     => 'Belangrijke Melding',
        ],
    ],
    'recent'        => [
        'title' => 'Onlangs gewijzigd :name',
    ],
    'settings'      => [
        'title' => 'Dashboard Instellingen',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Voeg een widget toe',
            'back_to_dashboard' => 'Terug naar dashboard',
            'edit'              => 'Wijzig een widget',
        ],
        'title'     => 'Campaign Dashboard Setup',
        'widgets'   => [
            'calendar'      => 'Kalender',
            'campaign'      => 'Campaign Header',
            'header'        => 'Header',
            'preview'       => 'Entiteit preview',
            'random'        => 'Willekeurige entiteit',
            'recent'        => 'Recentelijk aangepast',
            'unmentioned'   => 'Niet-genoemde entiteiten',
        ],
    ],
    'title'         => 'Dashboard',
    'widgets'       => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Wijzig de datum naar de volgende dag',
                'previous'  => 'Wijzig de datum naar de vorige dag',
            ],
            'events_today'      => 'Vandaag',
            'previous_events'   => 'Vorige',
            'upcoming_events'   => 'Aankomend',
        ],
        'campaign'      => [
            'helper'    => 'Deze widget geeft de campaign header weer. Deze widget wordt altijd weergegeven op het standaard dashboard.',
        ],
        'create'        => [
            'success'   => 'Widget toegevoegd aan het dashboard.',
        ],
        'delete'        => [
            'success'   => 'Widget verwijderd van het dashboard',
        ],
        'fields'        => [
            'name'  => 'Aangepaste widget naam',
            'text'  => 'Tekst',
            'width' => 'Breedte',
        ],
        'recent'        => [
            'entity-header' => 'Gebruik de entiteit header als afbeelding',
            'full'          => 'Volledig',
            'help'          => 'Toon alleen de laatst bijgewerkte entiteit, maar toon een hele preview van de entiteit',
            'helpers'       => [
                'entity-header' => 'Als je entiteit een entiteit header heeft (functie voor boosted campagnes), stel je deze widget in om die afbeelding te gebruiken in plaats van de afbeelding van de entiteit.',
                'full'          => 'Geef standaard de invoer van de hele entiteit weer in plaats van een voorbeeld.',
            ],
            'singular'      => 'Enkelvoud',
            'tags'          => 'Filter de lijst met onlangs gewijzigde entiteiten op gespecificeerde tags.',
            'title'         => 'Onlangs gewijzigd',
        ],
        'unmentioned'   => [
            'title' => 'Niet-genoemde entiteiten',
        ],
        'update'        => [
            'success'   => 'Widget aangepast.',
        ],
        'widths'        => [
            '0' => 'Auto',
            '12'=> 'Volledig (100%)',
            '3' => 'Mini (25%)',
            '4' => 'Klein (33%)',
            '6' => 'Half (50%)',
            '8' => 'Wijd (66%)',
        ],
    ],
];
