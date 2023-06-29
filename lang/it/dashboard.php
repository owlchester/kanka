<?php

return [
    'actions'       => [],
    'campaigns'     => [],
    'dashboards'    => [
        'actions'       => [
            'new'       => 'Nuova Pagina Principale',
            'switch'    => 'Vai alla Pagina Principale',
        ],
        'create'        => [
            'success'   => 'Nuova Pagina Principale della campagna :name creata.',
            'title'     => 'Nuova Pagina Principale della Campagna',
        ],
        'custom'        => [
            'text'  => 'Stai modificando la :name Pagina Principale della campagna.',
        ],
        'default'       => [
            'text'  => 'Stai modificando la Pagina Principale predefinita della campagna.',
            'title' => 'Pagina Principale Predefinita',
        ],
        'delete'        => [
            'success'   => 'Pagina Principale :name rimossa.',
        ],
        'fields'        => [
            'name'  => 'Nome Pagina Principale',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplica i widgets dalla Pagina Principale :name a questa nuova.',
        ],
        'pitch'         => 'Crea multiple Pagine Principali con permessi personalizzati per ogni ruolo all\'interno della campagna.',
        'placeholders'  => [
            'name'  => 'Nome della Pagina Principale',
        ],
        'update'        => [
            'success'   => 'Pagina Principale della campagna :name aggiornata.',
            'title'     => 'Aggiorna la Pagina Principale della campagna :name.',
        ],
    ],
    'helpers'       => [
        'setup' => 'Imposta la Pagina Principale della tua campagna.',
    ],
    'notifications' => [
        'modal' => [
            'title' => 'Notifica Importante',
        ],
    ],
    'recent'        => [],
    'settings'      => [
        'title' => 'Impostazioni della Pagina Principale',
    ],
    'setup'         => [
        'actions'   => [
            'back_to_dashboard' => 'Torna alla Pagina Principale',
        ],
        'title'     => 'Impostazioni della Pagina Principale della Campagna',
        'tutorial'  => [
            'text'  => 'Hai bisogno di aiuto per configurare la Pagina Principale della tua campagna? Leggi :blog per trovare aiuto e ispirazione.',
        ],
        'widgets'   => [
            'unmentioned'   => 'Lista di entità non menzionate',
        ],
    ],
    'title'         => 'Pagina Principale',
    'widgets'       => [
        'campaign'      => [
            'helper'    => 'Questo widget mostra l\'intestazione della campagna. Il widget è sempre visibile nella Pagina Principale predefinita.',
        ],
        'create'        => [
            'success'   => 'Widget aggiunto alla Pagina Principale.',
        ],
        'delete'        => [
            'success'   => 'Widget rimosso dalla Pagina Principale.',
        ],
        'fields'        => [
            'dashboard' => 'Pagina Principale',
        ],
        'preview'       => [
            'displays'  => [
                'expand'    => 'Voce espandibile',
                'full'      => 'Voce completa',
            ],
            'fields'    => [
                'display'   => 'Visualizza',
            ],
        ],
        'recent'        => [
            'advanced_filters'  => [
                'mentionless'   => 'Senza menzioni (entità che non menziona altre entità)',
                'unmentioned'   => 'Non menzionata (entità che non è menzionata da nessun altra)',
            ],
            'help'              => 'Visualizza solamente l\'ultima entità aggiornata, ma visualizza un\'anteprima completa per la stessa.',
        ],
        'unmentioned'   => [
            'title' => 'Entità non menzionate',
        ],
        'welcome'       => [
            'helper'    => 'Questo widget visualizza un messaggio di benvenuto sulla Pagina Principale che include link utili per i nuovi utenti di Kanka.',
        ],
        'widths'        => [
            '12'    => 'Intera (100%)',
        ],
    ],
];
