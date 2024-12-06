<?php

return [
    'actions'       => [
        'remove'    => 'Rimuovi premium',
        'unlock'    => 'Diventa premium',
    ],
    'create'        => [
        'actions'   => [
            'confirm'   => 'Diventa Premium!',
        ],
        'confirm'   => 'Che emozione! Stai per sbloccare le funzioni premium per :campaign. Questa operazione utilizzerà una delle campagne premium disponibili.',
        'duration'  => 'Le campagne premium rimangono tali fino a quando non vengono rimosse manualmente o fino alla scadenza dell\'abbonamento.',
        'pitch'     => 'Diventa un abbonato per sbloccare campagne premium.',
        'success'   => 'La campagna :campaign è ora premium. Goditi tutte le nuove fantastiche funzionalità!',
    ],
    'exceptions'    => [
        'already'       => 'Le funzioni premium sono già state sbloccate per questa campagna.',
        'out-of-stock'  => 'Non sono disponibili abbastanza campagne premium per sbloccare questa campagna. Rimuovi lo stato premium da un\'altra campagna oppure :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Diventa premium e contribuisci a sbloccare funzioni straordinarie per tutti i partecipanti.',
        'more'          => 'Scopri l\'elenco completo dei vantaggi nella nostra pagina :premium.',
        'title'         => 'Le campagne premium ricevono',
    ],
    'ready'         => [
        'available'         => 'Le tue campagne premium disponibili',
        'pricing'           => 'Tutti i nostri livelli di abbonamento includono almeno una campagna premium e partono da :amount al mese.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Diventa premium',
    ],
    'remove'        => [
        'confirm'   => 'Sì, sono sicuro',
        'cooldown'  => 'Questa funzione premium di :campaign può essere rimossa dopo :date.',
        'success'   => 'Le funzioni premium sono state rimosse dalla campagna :campaign. È ora possibile sbloccare le funzioni premium in un\'altra campagna.',
        'title'     => 'Rimuovendo le funzioni premium',
        'warning'   => 'Sei sicuro di voler rimuovere le funzionalità premium da :campaign? In questo modo sarà possibile sbloccare un\'altra campagna e nascondere tutti i contenuti e le funzionalità relative ai vantaggi fino a quando lo stato premium della campagna non sarà nuovamente abilitato.',
    ],
];
