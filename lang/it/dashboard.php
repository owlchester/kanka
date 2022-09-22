<?php

return [
    'actions'       => [
        'follow'    => 'Segui',
        'unfollow'  => 'Smetti di seguire',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count Moduli',
            'roles'     => ':count Ruoli',
            'users'     => ':count Utenti',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Seguire una campagna farà si che questa appaia nel selettore delle campagne (in alto a destra) sotto alle tue campagna.',
        'setup'     => 'Imposta la dashboard della tua campagna.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Capito',
            'title'     => 'Notifica iImportante',
        ],
    ],
    'recent'        => [
        'title' => ':name con modifiche recenti',
    ],
    'settings'      => [
        'title' => 'Impostazioni della Dashboard',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Aggiungi un widget',
            'back_to_dashboard' => 'Torna alla dashboard',
            'edit'              => 'Modifica un widget',
        ],
        'title'     => 'Impostazioni della Dashboard della Campagna',
        'widgets'   => [
            'calendar'  => 'Calendario',
            'preview'   => 'Anteprima Entità',
            'recent'    => 'Recente',
        ],
    ],
    'title'         => 'Dashboard',
    'widgets'       => [
        'calendar'  => [
            'actions'           => [
                'next'      => 'Cambia la data al giorno successivo',
                'previous'  => 'Cambia la data al giorno precedente',
            ],
            'events_today'      => 'Oggi',
            'previous_events'   => 'Precedente',
            'upcoming_events'   => 'Successivo',
        ],
        'create'    => [
            'success'   => 'Widget aggiunto alla dashboard',
        ],
        'delete'    => [
            'success'   => 'Widget rimosso dalla dashboard',
        ],
        'fields'    => [
            'text'  => 'Testo',
            'width' => 'Larghezza',
        ],
        'recent'    => [
            'full'      => 'Intero',
            'help'      => 'Visualizza solamente l\'ultima entità aggiornata, ma visualizza un\'antemprima completa per la stessa.',
            'helpers'   => [
                'full'  => 'Visualizza l\'intera entità in maniera predefinita invece di un\'anteprima.',
            ],
            'singular'  => 'Singola',
            'title'     => 'Modificati di recente',
        ],
        'update'    => [
            'success'   => 'Widget modificato.',
        ],
        'widths'    => [
            '0' => 'Auto',
            '12'=> 'Intera',
            '4' => 'Piccola',
            '6' => 'Metà',
        ],
    ],
];
