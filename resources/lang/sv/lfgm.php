<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Synkronisera',
        ],
        'errors'    => [
            'invalid_uuid'  => 'Ogiltigt LFGM kampanj id. Vänligen försök igen.',
        ],
        'helper'    => 'Välj en kampanj för att synka dina kommande händelser från :lfgm. Detta kommer lägga till en Anteckning med dina kommande händelser till den kampanjen och nåla fast den på kampanjens dashboard.',
        'successes' => [
            'sync'  => 'LFGM kalender synkad.',
        ],
        'title'     => 'LookingForGM.com Kampanj Synkronisering',
    ],
];
