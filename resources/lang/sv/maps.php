<?php

return [
    'actions'       => [
        'back'      => 'Tillbaka till :name',
        'edit'      => 'Redigera karta',
        'explore'   => 'Utforska',
    ],
    'create'        => [
        'success'   => 'Karta :name skapad.',
        'title'     => 'Ny Karta',
    ],
    'destroy'       => [
        'success'   => 'Karta :name borttagen.',
    ],
    'edit'          => [
        'success'   => 'Karta :name uppdaterad.',
        'title'     => 'Redigera Karta :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Denna karta behöver en bild för att kunna renderas på dashboardet.',
        ],
        'explore'   => [
            'missing'   => 'Vänligen lägg till en bild till denna karta innan du kan utforska den.',
        ],
    ],
    'fields'        => [
        'center_x'          => 'Standard Longitud Position',
        'center_y'          => 'Standard Latitud Position',
        'distance_measure'  => 'Distansmätning',
        'distance_name'     => 'Distansenhet',
        'grid'              => 'Rutnät',
        'initial_zoom'      => 'Initial zoom',
        'map'               => 'Huvudkarta',
        'maps'              => 'Kartor',
        'max_zoom'          => 'Maximal zoom',
        'min_zoom'          => 'Minimal zoom',
        'name'              => 'Namn',
        'type'              => 'Typ',
    ],
    'helpers'       => [
        'center'            => 'Att ändra följande värden kommer kontrollera vilket område kartan är fokuserad på. Att lämna dom tomma kommer resultera i att kartans centrum kommer vara i fokus.',
        'descendants'       => 'Denna lista innehåller kartor som är grupperade under denna karta, och inte bara dom direkt under den.',
        'distance_measure'  => 'Genom att ge kartan en distansmätning aktiveras mätnings verktyget i utforsknings läget.',
        'grid'              => 'Definiera en rutnäts storlek som visas i utforsknings läget.',
        'initial_zoom'      => 'Initiala zoom nivån en karta kommer laddas med. Standard värdet är :default, medans det högsta tillåtna värdet är :max och det lägsta tillåtna värdet är :min.',
        'max_zoom'          => 'Så mycket en karta kan zoomas in. Standard värdet är :default, medans det högsta värdet tillåtet är :max.',
        'min_zoom'          => 'Så mycket en karta kan zoomas ut. Standard värdet är :default, medans det lägsta värdet tillåtet är :min.',
        'missing_image'     => 'Spara kartan med en bild innan det är möjligt att lägga till lager och markeringar.',
    ],
    'index'         => [
        'add'   => 'Ny Karta',
        'title' => 'Kartor',
    ],
    'maps'          => [
        'title' => 'Kartor för :name',
    ],
    'panels'        => [
        'groups'    => 'Grupper',
        'layers'    => 'Lager',
        'markers'   => 'Markeringar',
        'settings'  => 'Inställningar',
    ],
    'placeholders'  => [
        'center_x'          => 'Lämna tom för att ladda kartan i mitten',
        'center_y'          => 'Lämna tom för att ladda kartan i mitten',
        'distance_measure'  => 'Enheter per pixel',
        'distance_name'     => 'Namn på distans enhet (kilometer, mil)',
        'grid'              => 'Distans i pixlar mellan rutnäts element. Lämna tomt för att dölja rutnät.',
        'name'              => 'Namn på kartan',
        'type'              => 'Fängelsehåla, Stad, Galax',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Kartor',
        ],
        'title' => 'Karta :name',
    ],
];
