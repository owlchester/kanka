<?php

return [
    'actions'   => [
        'show-old'  => 'Cambiamenti',
    ],
    'cta'       => 'Visualizza un registro di tutte le modifiche recenti apportate alla campagna.',
    'empty'     => 'Nessun dato',
    'filters'   => [
        'all-actions'   => 'Tutte le azioni',
        'all-users'     => 'Tutti i membri',
        'no-results'    => 'Nessun risultato da visualizzare. Prova altri filtri o torna dopo aver apportato modifiche alle entità della campagna.',
    ],
    'helpers'   => [
        'base'      => 'Questa interfaccia contiene le modifiche recenti alle entità della campagna per un periodo massimo di :amount mesi, mostrando prima le modifiche più recenti.',
        'changes'   => 'I seguenti campi avevano in precedenza questi dati.',
    ],
    'log'       => [
        'create'        => ':user ha creato :entity',
        'create_post'   => ':user ha creato il post ":post" su :entity',
        'delete'        => ':user ha eliminato :entity',
        'delete_post'   => ':user ha eliminato un post su :entity',
        'reorder_post'  => ':user ha riordinato i post di :entity',
        'restore'       => ':user ha recuperato :entity',
        'update'        => ':user ha modificato :entity',
        'update_post'   => ':user ha modificato il post ":post" su :entity',
    ],
    'title'     => 'Cronologia',
    'unknown'   => [
        'entity'    => 'un\'entità sconosciuta',
    ],
];
