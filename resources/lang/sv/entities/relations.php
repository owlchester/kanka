<?php

return [
    'create'        => [
        'success'   => 'Förbindelse :target tillagd till :entity.',
        'title'     => 'Ny förbindelse för :name',
    ],
    'destroy'       => [
        'success'   => 'Förbindelse :target borttagen för :entity.',
    ],
    'fields'        => [
        'attitude'  => 'Attityd',
        'is_star'   => 'Fastnålad',
        'relation'  => 'Förbindelse',
        'target'    => 'Mål',
        'two_way'   => 'Skapa speglad förbindelse',
    ],
    'helper'        => 'Skapa förbindelser mellan entiteter med attityder och synlighet. Förbindelser kan också nålas fast på entitetens meny.',
    'hints'         => [
        'attitude'  => 'Detta valfria fällt kan användas för att definiera standard ordningen förbindelser visas i som fallande ordning.',
        'mirrored'  => [
            'text'  => 'Denna förbindelse är speglad med :link.',
            'title' => 'Speglad',
        ],
        'two_way'   => 'Om du väljer att skapa en speglad förbindelse skapas samma förbindelse på målet. Dock om du redigerar en så uppdateras inte den speglade.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 till 100, där 100 är väldigt positiv',
        'relation'  => 'Rival, Bästa Vän, Syskon',
        'target'    => 'Välj en entitet',
    ],
    'show'          => [
        'title' => 'Förbindelser för :name',
    ],
    'teaser'        => 'Boosta kampanjen för att få tillgång till förbindelse utforskaren. Klicka för att lära dig mer om boostade kampanjer.',
    'types'         => [
        'family_member'         => 'Familjemedlem',
        'organisation_member'   => 'Organisationsmedlem',
    ],
    'update'        => [
        'success'   => 'Förbindelse :target uppdaterad för :entity.',
        'title'     => 'Uppdatera förbindelse för :name',
    ],
];
