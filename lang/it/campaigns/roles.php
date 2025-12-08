<?php

return [
    'actions'   => [
        'status'    => 'Stato :status',
    ],
    'public'    => [],
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
