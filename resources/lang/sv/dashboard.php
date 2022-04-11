<?php

return [
    'actions'       => [
        'follow'    => 'Följ',
        'unfollow'  => 'Sluta Följa',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count Moduler',
            'roles'     => ':count Roller',
            'users'     => ':count Användare',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Redigera',
            'new'       => 'Nytt Dashboard',
            'switch'    => 'Ändra till Dashboard',
        ],
        'boosted'       => ':boosted_campaigns kan skapa anpassade Dashboards för var och en av kampanj rollerna.',
        'create'        => [
            'success'   => 'Nytt kampanjdashboard :name skapat.',
            'title'     => 'Nytt Kampanjdashboard',
        ],
        'custom'        => [
            'text'  => 'Du redigerar för tillfället :name Dashboarden för kampanjen.',
        ],
        'default'       => [
            'text'  => 'Du redigerar för tillfället standard Dashboarden för kampanjen.',
            'title' => 'Standard Dashboard',
        ],
        'delete'        => [
            'success'   => 'Dashboard :name borttagen.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Kopiera widgetar',
            'name'          => 'Dashboard name',
            'visibility'    => 'Synlighet',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplicera widgetarna från :name dashboarden till den här nya.',
        ],
        'placeholders'  => [
            'name'  => 'Namn på Dashboarden',
        ],
        'update'        => [
            'success'   => 'Kampanjdashboard :name uppdaterad.',
            'title'     => 'Uppdatera kampanjdashboard :name',
        ],
        'visibility'    => [
            'default'   => 'Standard',
            'none'      => 'Ingen',
            'visible'   => 'Synlig',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Att följa en kampanj gör att den visas i kampanj bytaren (uppe till vänster) under din kampanj.',
        'setup'     => 'Välj din kampanjs dashboard.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Uppfattat',
            'title'     => 'Viktig Notifikation',
        ],
    ],
    'recent'        => [
        'title' => 'Nyligen modifierad :name',
    ],
    'settings'      => [
        'title' => 'Dashboard Inställnigar',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Lägg till widget',
            'back_to_dashboard' => 'Tillbaka till dashboard',
            'edit'              => 'Redigera en widget',
        ],
        'title'     => 'Kampanjdashboard Installation',
        'widgets'   => [
            'calendar'      => 'Kalender',
            'campaign'      => 'Kampanjrubrik',
            'header'        => 'Rubrik',
            'preview'       => 'Entitets Förhandsvisning',
            'random'        => 'Slumpad entitet',
            'recent'        => 'Nyligen modifierad',
            'unmentioned'   => 'Onämnda entiteter',
        ],
    ],
    'title'         => 'Dashboard',
    'widgets'       => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Ändra datum till nästa dag',
                'previous'  => 'Ändra dag till föregående dag',
            ],
            'events_today'      => 'Idag',
            'previous_events'   => 'Föregående',
            'upcoming_events'   => 'Kommande',
        ],
        'campaign'      => [
            'helper'    => 'Denna widget visar kampanjrubriken. Denna widget visas alltid på standard dashboarden.',
        ],
        'create'        => [
            'success'   => 'Widget tillagd på dashborden.',
        ],
        'delete'        => [
            'success'   => 'Widget borttagen från dashborden.',
        ],
        'fields'        => [
            'name'  => 'Anpassat widget namn',
            'text'  => 'Text',
            'width' => 'Bredd',
        ],
        'recent'        => [
            'entity-header' => 'Använd entitetsrubrik som bild.',
            'full'          => 'Full',
            'help'          => 'Visa bara den senast uppdaterade entiteten, men visa en hel förhandsvisning för entiteten',
            'helpers'       => [
                'entity-header' => 'Om din entitet har en entitetsrubrik (boostad kampanj funktion), ställ in widgeten att använda den bilden istället för entitetens bild.',
                'full'          => 'Visa hela entitetens innehåll som standard istället för en förhandsvisning.',
            ],
            'singular'      => 'Unik',
            'tags'          => 'Filtrera listan över nyligen modifierade entiteter med specificerade taggar.',
            'title'         => 'Nyligen modifierade',
        ],
        'unmentioned'   => [
            'title' => 'Onämnda entiteter',
        ],
        'update'        => [
            'success'   => 'Widget modifierad.',
        ],
        'widths'        => [
            '0' => 'Auto',
            '12'=> 'Full (100%)',
            '3' => 'Mycket liten (25%)',
            '4' => 'Liten (33%)',
            '6' => 'Halv (50%)',
            '8' => 'Bred (66%)',
        ],
    ],
];
