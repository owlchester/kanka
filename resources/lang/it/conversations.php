<?php

return [
    'create'        => [
        'description'   => 'Crea una nuova conversazione',
        'success'       => 'Conversazione \':name\' creata.',
        'title'         => 'Nuova conversazione',
    ],
    'destroy'       => [
        'success'   => 'Conversazione \':name\' rimossa.',
    ],
    'edit'          => [
        'description'   => 'Aggiorna la conversazione',
        'success'       => 'Conversazione \':name\' aggiornata.',
        'title'         => 'Conversazione :name',
    ],
    'fields'        => [
        'messages'      => 'Messaggi',
        'name'          => 'Nome',
        'participants'  => 'Partecipanti',
        'target'        => 'Bersaglio',
        'type'          => 'Tipo',
    ],
    'hints'         => [
        'participants'  => 'Per favore aggiungi partecipanti alla tua conversazione premendo l\'icona :icon in altro a destra.',
    ],
    'index'         => [
        'add'           => 'Nuova conversazione',
        'description'   => 'Gestisci la categoria di :name.',
        'header'        => 'Conversazioni in :name',
        'title'         => 'Conversazioni',
    ],
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
        'create'        => [
            'success'   => 'Partecipante :entity aggiunto alla conversazione.',
        ],
        'description'   => 'Aggiungi o rimuovi partecipanti di una conversazione',
        'destroy'       => [
            'success'   => 'Partecipante :entity rimosso dalla conversazione.',
        ],
        'modal'         => 'Partecipanti',
        'title'         => 'Partecipanti di :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome della conversazione',
        'type'  => 'In Gioco, Preparazione, Trama',
    ],
    'show'          => [
        'description'   => 'Una vista dettagliata della conversazione',
        'title'         => 'Conversazione :name',
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
