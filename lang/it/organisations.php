<?php

return [
    'create'        => [
        'title' => 'Nuova Organizzazione',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Dismessa',
        'members'       => 'Membri',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_defunct'    => 'Questa organizzazione è dismessa.',
    ],
    'index'         => [],
    'members'       => [
        'destroy'       => [
            'success'   => 'Membro rimosso da :name.',
        ],
        'edit'          => [
            'title' => 'Membro Aggiornato per :name',
        ],
        'fields'        => [
            'parent'    => 'Superiore',
            'pinned'    => 'Fissato',
            'role'      => 'Ruolo',
            'status'    => 'Stato di affiliazione',
        ],
        'helpers'       => [
            'all_members'   => 'Tutti i personaggi che sono membri di questa organizzazione e delle sue sotto-organizzazioni.',
            'members'       => 'Tutti i personaggi che fanno parte di questa organizzazione.',
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
    'placeholders'  => [
        'type'  => 'Culto, Gang, Ribellione, Fandom',
    ],
    'show'          => [],
];
