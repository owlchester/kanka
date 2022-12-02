<?php

return [
    'create'        => [
        'title' => 'Nuova conversazione',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Conversazione :name',
    ],
    'fields'        => [
        'is_closed'     => 'Chiusa',
        'messages'      => 'Messaggi',
        'participants'  => 'Partecipanti',
    ],
    'hints'         => [
        'participants'  => 'Per favore aggiungi partecipanti alla tua conversazione premendo l\'icona :icon in altro a destra.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Messaggio rimosso.',
        ],
        'is_updated'    => 'Aggiornata',
        'load_previous' => 'Carica i messaggi precedenti',
        'placeholders'  => [
            'message'   => 'Il tuo messaggio',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Partecipante :entity aggiunto alla conversazione.',
        ],
        'destroy'   => [
            'success'   => 'Partecipante :entity rimosso dalla conversazione.',
        ],
        'modal'     => 'Partecipanti',
        'title'     => 'Partecipanti di :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome della conversazione',
        'type'  => 'In Gioco, Preparazione, Trama',
    ],
    'show'          => [
        'is_closed' => 'Conversazione chiusa.',
    ],
    'tabs'          => [
        'conversation'  => 'Conversazione',
        'participants'  => 'Partecipanti',
    ],
    'targets'       => [
        'characters'    => 'Personaggi',
        'members'       => 'Membri',
    ],
];
