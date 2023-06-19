<?php

return [
    'actions'   => [
        'status'    => 'Stato :status',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'La campagna è attualmente privata.',
            'public'    => 'La campagna è attualmente pubblica.',
        ],
        'description'   => 'Imposta le autorizzazioni per il ruolo pubblico per visualizzare le entità dei seguenti moduli della campagna. Un utente è considerato automaticamente nel ruolo pubblico se sta visualizzando la campagna senza essere uno dei suoi membri.',
        'test'          => 'Per testare le autorizzazioni per il ruolo pubblico, apri la Dashboard della campagna :url in una finestra di navigazione in incognito.',
    ],
    'show'      => [
        'title' => 'Autorizzazioni del :role - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Membri del ruolo :role non possono più :action le :entities',
        'enabled'   => 'Membri del ruolo :role possono ora :action le :entities',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'I membri del ruolo :name hanno accesso a tutto nella campagna e non possono essere rimossi da altri membri del ruolo. Dopo :amount minuti, solo loro possono rimuovere se stessi dal ruolo.',
    ],
];
