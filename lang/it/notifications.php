<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'       => 'La campagna :campaign sta venendo potenziata dall\'utente :user.',
            'remove'    => ':user non sta più potenziando la campagna :campaign.',
        ],
        'export'        => 'Un\'esportazione di una campagna è disponibile. Il link sarà disponibile per :time minuti.',
        'export_error'  => 'Abbiamo riscontrato un errore nell\'esportazione della tua campagna. Per favore contattaci se questo problema dovesse persistere.',
        'join'          => ':user si è unito alla campagna :campaign',
        'leave'         => ':user ha abbandonato la campagna :campaign',
        'role'          => [
            'add'       => 'Sei stato assegnato al ruolo :role nella campagna :campaign.',
            'remove'    => 'Sei stato rimosso dal ruolo :role nella campagna :campaign.',
        ],
    ],
    'header'            => 'Hai :count notifiche',
    'index'             => [
        'title' => 'Notifiche',
    ],
    'no_notifications'  => 'Attualmente non ci sono notifiche',
    'subscriptions'     => [
        'charge_fail'   => 'È stato riscontrato un errore durante l\'elaborazione del tuo pagamento. Per favore attendi un momento mentre proviamo di nuovo. Se non cambia nulla, per favore contattaci.',
        'ended'         => 'Il tuo abbonamento a Kanka è terminato. I potenziamenti per le tue campagne e i tuoi ruoli di Discord sono stati rimossi. Speriamo di vederti tornare presto!',
        'failed'        => 'Il tuo abbonamento a Kanka è stato cancellato dopo troppi tentativi falliti di addebito sulla tua carta. Per favore vai sulle impostazioni del tuo abbonamento e prova ad aggiornare i tuoi dettagli di pagamento.',
        'started'       => 'Il tuo abbonamento a Kanka è iniziato.',
    ],
];
