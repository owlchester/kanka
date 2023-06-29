<?php

return [
    'create'        => [],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Dismessa',
    ],
    'helpers'       => [
        'nested_without'    => 'Visualizzazione di tutte le organizzazioni che non hanno un\'organizzazione genitore. Fai clic su una riga per visualizzare le organizzazioni figlio.',
    ],
    'hints'         => [
        'is_defunct'    => 'Questa organizzazione è dismessa.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'submit'    => 'Aggoiungi membro',
        ],
        'fields'        => [
            'parent'    => 'Superiore',
            'pinned'    => 'Fissato',
            'status'    => 'Stato di affiliazione',
        ],
        'helpers'       => [
            'all_members'   => 'Tutti i personaggi che sono membri di questa organizzazione e delle sue sotto-organizzazioni.',
            'pinned'        => 'Scegli se questo membro deve essere mostrato nella sezione fissata della panoramica delle entità associate.',
        ],
        'pinned'        => [
            'both'  => 'Fissata a entrambe',
            'none'  => 'Fissata da nessuna parte',
        ],
        'placeholders'  => [
            'parent'    => 'Chi è il superiore di questo membro',
            'role'      => 'Leader, Membro, Alto Septon, Maestro di Spionaggio',
        ],
        'status'        => [
            'active'    => 'Membro Attivo',
            'inactive'  => 'Membro Inattivo',
            'unknown'   => 'Stato Sconosciuto',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [],
    'show'          => [],
];
