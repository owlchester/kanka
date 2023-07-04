<?php

return [
    'actions'   => [
        'boost_name'    => 'Potenzia :name',
    ],
    'available' => 'Potenziamenti disponibili :amount/:total',
    'benefits'  => [
        'boosted'       => 'Potenziando una campagna con :one potenziamento si sblocca l\'accesso al :marketplace, alle opzioni di tematizzazione, ai caricamenti più grandi per tutti i membri, al recupero delle entità cancellate e :more ancora.',
        'more'          => 'altre funzioni pazzesche',
        'superboosted'  => 'Superpotenziando una campagna con :amount potenziamenti si sbloccano tutti i vantaggi di una campagna potenziata, oltre a una galleria della campagna, log completi delle modifiche apportate alle entità e :more ancora.',
    ],
    'boost'     => [
        'actions'   => [
            'confirm'   => 'Potenziala!',
            'remove'    => 'Smetti di potenziare :campaign',
            'subscribe' => 'Abbonati a Kanka',
            'upgrade'   => 'Aggiorna il tuo abbonamento',
        ],
        'confirm'   => 'Che emozione! Stai per potenziare :campaign. Questo assegnerà uno (:cost) dei tuoi potenziamenti di campagna disponibili.',
        'duration'  => 'I potenziamenti assegnati rimangono tali fino a quando non vengono rimossi manualmente o fino al termine dell\'abbonamento.',
        'errors'    => [
            'boosted'           => 'Oh oh, sembra che la :campaign sia già potenziata!',
            'out-of-boosters'   => 'Oh no! Non hai abbastanza potenziamenti disponibili. Hai :available e hai bisogno di :cost. O smetti di potenziare altre campagne o :upgrade.',
        ],
        'pitch'     => 'Diventa un abbonato per sbloccare i potenziamenti di campagna.',
        'success'   => 'La campagna :campaign è ora potenziata. Goditi tutte le nuove fantastiche funzioni!',
        'title'     => 'Potenzia :campaign',
        'upgrade'   => 'aggiorna il tuo abbonamento',
    ],
    'campaign'  => [
        'boosted'       => 'Potenziata da :user da :time',
        'premium'       => 'Premium grazie a :user da :time',
        'standard'      => 'Standard',
        'superboosted'  => 'Superpotenziata da :user da :time',
        'unboosted'     => 'Depotenziata',
    ],
    'intro'     => [
        'anyone'    => 'Non sei limitato a potenziare solo le campagne che hai creato. Puoi potenziare qualsiasi campagna di cui fai parte o che puoi vedere. Questo include le campagne in cui sei un giocatore o una :public che ti piace.',
        'data'      => 'Quando una campagna non viene più potenziata, l\'accesso alle funzioni potenziate viene rimosso. Tuttavia, non viene eliminato alcun contenuto, per cui se la campagna viene nuovamente incrementata in futuro, l\'accesso viene ripristinato.',
        'first'     => 'Le funzioni avanzate si sbloccano assegnando i potenziamenti per potenziare o superpotenziare una campagna. La quantità di potenziamenti di cui disponi è determinata dal tuo :subscription. Questo numero è disponibile in ogni momento quando si è abbonati. Il potenziamento di una campagna le assegna uno dei vostri potenziamenti, mentre il superpotenziamenti di una campagna ne assegna tre.',
    ],
    'pitch'     => [
        'benefits'      => [
            'backup'        => 'Recupera un\'entità precedentemente cancellata per un periodo massimo di :amount giorni.',
            'customisable'  => 'Personalizzazione completa dell\'aspetto di una campagna',
            'entities'      => 'Miglior controllo su come le entità appaiono e si comportano',
            'icons'         => 'Accedi a migliaia di bellissime icone per mappe e linee temporali',
            'relations'     => 'Esplora i legami di un\'entità nell\'esploratore visuale',
            'title'         => 'Le campagne potenziate prendono',
            'upload'        => 'Dimensioni di caricamento maggiori per tutti i membri delle campagne',
        ],
        'description'   => 'Assegna i potenziamenti alle campagne e contribuisci a sbloccare funzioni straordinarie per tutti i partecipanti. Non sei impressionato dalle campagne potenziate? Ci pensiamo noi con le campagne superpotenziate!',
        'more'          => 'Consulta l\'elenco completo dei vantaggi sulla nostra pagina :boosters.',
        'title'         => 'Porta una campagna a un livello superiore con la personalizzazione e i vantaggi per tutti i suoi membri',
    ],
    'ready'     => [
        'available'         => 'I tuoi potenziamenti di campagna disponibili.',
        'pricing'           => 'Tutti i nostri livelli di abbonamento includono almeno un potenziamento di campagna e iniziano con :amount al mese.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Potenzia una campagna',
    ],
    'superboost'=> [
        'actions'   => [
            'confirm'   => 'Superpotenziala!',
            'instead'   => 'Superpotenziala per :count!',
            'remove'    => 'Smetti di superpotenziare :campaign',
        ],
        'confirm'   => 'Che emozione! Stai per superpotenziare :campaign. Questo assegnerà tre (:cost) dei tuoi potenziamenti di campagna disponibili.',
        'errors'    => [
            'boosted'   => 'Oh oh, sembra che la :campaign sia già superpotenziata!',
        ],
        'success'   => 'La campagna :campaign è ora superpotenziata. Goditi tutte le nuove fantastiche funzioni!',
        'title'     => 'Superpotenzia :campaign',
        'upgrade'   => 'Pronti per l\'esperienza Kanka definitiva? Superpotenziare :campaign assegnerà :cost ulteriori potenziamenti di campagna.',
    ],
    'title'     => 'Potenziamenti di Campagna',
    'unboost'   => [
        'confirm'   => 'Sì, sono sicuro',
        'status'    => [
            'boosting'      => 'Potenziare',
            'superboosting' => 'Superpotenziare',
        ],
        'success'   => 'La campagna :campaign è ora non più potenziata, e i tuoi potenziamenti sono ora disponibili di nuovo.',
        'title'     => 'Depotenzia una campagna',
        'warning'   => 'Sei sicuro di voler interrompere :action :campaign? Questo rilascerà i potenziamenti assegnati e nasconderà tutti i contenuti e le funzionalità relative ai vantaggi fino a quando la campagna non verrà nuovamente potenziata.',
    ],
];
