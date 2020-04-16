<?php

return [
    'actions'           => [
        'follow'    => 'Segui',
        'unfollow'  => 'Smetti di seguire',
    ],
    'campaigns'         => [
        'manage'    => 'Gestisci la campagna',
        'tabs'      => [
            'modules'   => ':count Moduli',
            'roles'     => ':count Ruoli',
            'users'     => ':count Utenti',
        ],
    ],
    'description'       => 'La dimora della tua creatività',
    'helpers'           => [
        'follow'    => 'Seguire una campagna farà si che questa appaia nel selettore delle campagne (in alto a destra) sotto alle tue campagna.',
        'setup'     => 'Imposta la dashboard della tua campagna.',
    ],
    'latest_release'    => 'Ultima Versione',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Capito',
            'title'     => 'Notifica iImportante',
        ],
    ],
    'recent'            => [
        'add'           => 'Crea :name',
        'no_entries'    => 'Attualmente non ci sono elementi di questo tipo.',
        'title'         => ':name con modifiche recenti',
        'view'          => ':name, visualizzali tutti',
    ],
    'settings'          => [
        'description'   => 'Personalizza quello che vedi nella tua dashboard',
        'edit'          => [
            'success'   => 'I tuoi cambiamenti sono stati salvati.',
        ],
        'fields'        => [
            'helper'        => 'Puoi facilmente cambiare quello che vedi sulla tua dashboard. Per favore sii consapevole che questo influenzerà tutte le tue campagne senza riguardo per le impostazioni specifiche della campagna.',
            'recent_count'  => 'Numero di elementi recenti',
        ],
        'title'         => 'Impostazioni della Dashboard',
    ],
    'setup'             => [
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
    'title'             => 'Dashboard',
    'welcome'           => [
        'body'  => <<<'TEXT'
Benvenuto in Kanka! La tua prima campagna è stata creata e vi abbiamo inserito un po' di entità di esempio come ispirazione (le potrai cancellare in qualsiasi momento).

Vorrai probabilmente iniziale aggiungendo qualche tua entità, quindi seleziona una categoria da sinistra ed iniziamo.
Puoi disabilitare le tipologie di entità non necessartie dalle impostazioni della campagna, questo le nasconderà dal menù.

Alcuni consigli per iniziare:
- Puoi digitare @nomeEntità per colleghare specifiche entità. Il testo del link mostrato sarà automaticamente aggiornato se rinominerai od aggiornerai l'entità collegata.
- Puoi configurare i settaggi specifici per l'account come il tema o gli elementi da mostrare per ogni pagina dal tuo profilo accessibile da in alto a destra.
- C'è una lista crescente di tutorial su :youtube. I tutotial includono esempi sugli attributi e come condividere la tua campagna con le altre persone. Anche le :faq possono esserti utili.
- Se ha delle domande, dei suggerimento o vuoi solamente chattare unisciti a noi su :discord
TEXT
,
    ],
    'widgets'           => [
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
