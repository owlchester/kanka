<?php

return [
    'create'        => [
        'title' => 'Nuovo Evento',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'date'      => 'Data',
        'image'     => 'Immagine',
        'location'  => 'Luogo',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'title' => 'Eventi',
    ],
    'placeholders'  => [
        'date'      => 'Una data per il tuo evento',
        'location'  => 'Scegli il luogo',
        'name'      => 'Nome dell\'evento',
        'type'      => 'Cerimonia, Festival, Disastro, Battaglia, Nascita',
    ],
    'show'          => [
        'tabs'  => [
            'events'    => 'Eventi',
        ],
    ],
    'tabs'          => [
        'calendars' => 'Elementi del Calendario',
    ],
];
