<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'              => 'La tua candidatura alla campagna :campaign è stata approvata.',
            'approved_message'      => 'La tua candidatura alla campagna :campaign è stata approvata. Messaggio allegato: :reason',
            'new'                   => 'Nuova candidatura per :campaign.',
            'rejected'              => 'La tua candidatura alla campagna :campaign è stata rifiutata. Motivo dichiarato: :reason',
            'rejected_no_message'   => 'La tua candidatura alla campagna :campaign è stata rifiutata.',
        ],
        'asset_export'          => 'È disponibile l\'esportazione degli asset di una campagna. Il link è disponibile in :time minuti.',
        'asset_export_error'    => 'Si è verificato un errore durante l\'esportazione degli asset della campagna. Questo accade nelle campagne di grandi dimensioni.',
        'boost'                 => [
            'add'           => 'La campagna :campaign viene potenziata da :user.',
            'remove'        => ':user non sta più potenziando la campagna :campaign.',
            'superboost'    => 'La campagna :campaign sta venendo supportata da :user.',
        ],
        'deleted'               => 'La campagna :campaign è stata eliminata.',
        'export'                => 'Un\'esportazione di una campagna è disponibile. Il link sarà disponibile in :time minuti.',
        'export_error'          => 'Abbiamo riscontrato un errore nell\'esportazione delle entità della campagna. Per favore contattaci se questo problema dovesse persistere.',
        'hidden'                => 'La campagna :campaign è ora nascosta dalla pagina delle campagne pubbliche.',
        'import'                => [
            'failed'    => 'L\'importazione della campagna :campaign non è riuscita.',
            'success'   => 'La campagna :campaign ha terminato l\'importazione.',
        ],
        'join'                  => ':user si è unito alla campagna :campaign.',
        'leave'                 => ':user ha lasciato la campagna :campaign.',
        'plugin'                => [
            'deleted'   => 'Il plugin :plugin è stato eliminato dal marketplace e rimosso dalla tua campagna :campagna.',
        ],
        'premium'               => [
            'add'       => 'Le funzionalità premium sono state sbloccate per la campagna :campaign da :user.',
            'remove'    => 'L\'utente :user non sblocca più le funzioni premium per la campagna :campaign.',
        ],
        'removed-image'         => 'L\'immagine o l\'intestazione di :entity è stata rimossa a causa di una violazione del copyright.',
        'role'                  => [
            'add'       => 'Sei stato aggiunto al ruolo :role nella campagna :campaign.',
            'remove'    => 'Sei stato rimosso dal ruolo :role nella campagna :campaign.',
        ],
        'shown'                 => 'La campagna :campaign è ora visibile nella pagina delle campagne pubbliche.',
        'troubleshooting'       => [
            'joined'    => 'Il membro del team Kanka :user ha aderito alla campagna :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Pulisci tutto',
        'success'   => 'Notifiche rimosse.',
        'title'     => 'Pulisci le notifiche',
    ],
    'features'          => [
        'approved'  => 'La tua idea :feature è stata approvata.',
        'finished'  => 'La tua idea :feature è ora disponibile su Kanka!',
        'rejected'  => 'La tua idea :feature è stata rifutata, motivo: :reason.',
    ],
    'header'            => 'Hai :count notifiche.',
    'index'             => [
        'title' => 'Notifiche',
    ],
    'map'               => [
        'chunked'   => 'La mappa :name ha terminato il raggruppamento ed è ora utilizzabile.',
    ],
    'no_notifications'  => 'Attualmente non ci sono notifiche. Le notifiche appariranno qui una volta che ne avrete ricevuto qualcuna.',
    'subscriptions'     => [
        'charge_fail'   => 'Si è verificato un errore durante l\'elaborazione del pagamento. Per favore, attendi un momento mentre proviamo di nuovo. Se non cambia nulla, contattaci.',
        'deleted'       => 'L\'abbonamento a Kanka è stato annullato automaticamente dopo troppi tentativi falliti di addebito sulla carta. Per favore, accedi alle impostazioni dell\'abbonamento e prova ad aggiornare i tuoi dati di pagamento.',
        'ended'         => 'Il tuo abbonamento a Kanka è terminato. Le tue campagne premium e i tuoi ruoli su Discord sono stati disattivati. Speriamo di rivederti presto!',
        'failed'        => 'L\'abbonamento a Kanka è stato annullato automaticamente dopo troppi tentativi falliti di addebito sulla carta. Per favore, accedi alle impostazioni dell\'abbonamento e prova ad aggiornare i tuoi dati di pagamento.',
        'started'       => 'Il tuo abbonamento a Kanka è appena iniziato.',
    ],
    'unread'            => 'Nuova Notifica',
];
