<?php

return [
    'create'        => [
        'description'   => 'Crea un nuovo evento',
        'success'       => 'Evento \':name\' creato.',
        'title'         => 'Nuovo Evento',
    ],
    'destroy'       => [
        'success'   => 'Evento \':name\' rimosso.',
    ],
    'edit'          => [
        'success'   => 'Evento \':name\' aggiornato.',
        'title'     => 'Modifica Evento :name',
    ],
    'fields'        => [
        'date'      => 'Data',
        'image'     => 'Immagine',
        'location'  => 'Luogo',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nuovo Evento',
        'description'   => 'Gestisci gli eventi di :name',
        'header'        => 'Eventi di :name',
        'title'         => 'Eventi',
    ],
    'placeholders'  => [
        'date'      => 'Una data per il tuo evento',
        'location'  => 'Scegli il luogo',
        'name'      => 'Nome dell\'evento',
        'type'      => 'Cerimonia, Festival, Disastro, Battaglia, Nascita',
    ],
    'show'          => [
        'description'   => 'Una vista dettagliata dell\'evento',
        'tabs'          => [
            'information'   => 'Informazioni',
        ],
        'title'         => 'Evento :name',
    ],
    'tabs'          => [
        'calendars' => 'Elementi del Calendario',
    ],
];
