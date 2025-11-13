<?php

return [
    'actions'       => [
        'follow'    => 'Segui',
        'join'      => 'Unisciti',
        'unfollow'  => 'Smetti di seguire',
    ],
    'campaigns'     => [],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Modifica nome & autorizzazioni',
            'new'       => 'Nuova Pagina Principale',
            'switch'    => 'Vai alla Pagina Principale',
        ],
        'create'        => [
            'success'   => 'Nuova Pagina Principale della campagna :name creata.',
            'title'     => 'Nuova Pagina Principale della Campagna',
        ],
        'custom'        => [
            'text'  => 'Stai modificando la Pagina Principale :name della campagna.',
        ],
        'default'       => [
            'text'  => 'Stai modificando la Pagina Principale predefinita della campagna.',
            'title' => 'Pagina Principale Predefinita',
        ],
        'delete'        => [
            'success'   => 'Pagina Principale :name rimossa.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copia widgets',
            'name'          => 'Nome Pagina Principale',
            'visibility'    => 'Visibilità',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplica i widgets dalla Pagina Principale :name a questa nuova.',
        ],
        'pitch'         => 'Crea multiple Pagine Principali con autorizzazioni personalizzate per ogni ruolo all\'interno della campagna.',
        'placeholders'  => [
            'name'  => 'Nome della Pagina Principale',
        ],
        'update'        => [
            'success'   => 'Pagina Principale della campagna :name aggiornata.',
            'title'     => 'Aggiorna la Pagina Principale della campagna :name.',
        ],
        'visibility'    => [
            'default'   => 'Predefinito',
            'none'      => 'Nessuna',
            'visible'   => 'Visibile',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Seguendo una campagna, questa apparirà nel selettore delle campagne sotto le vostre campagne.',
        'join'      => 'Questa campagna è aperta a nuovi membri. Clicca per unirti.',
    ],
    'notifications' => [],
    'recent'        => [],
    'settings'      => [],
    'setup'         => [
        'actions'   => [
            'add'               => 'Aggiungi un widget',
            'back_to_dashboard' => 'Torna alla Pagina Principale',
            'edit'              => 'Modifica un widget',
            'new'               => 'Nuovo widget :type',
        ],
        'reorder'   => [
            'success'   => 'Widget riordinati.',
        ],
        'title'     => 'Impostazioni della Pagina Principale della Campagna',
        'tutorial'  => [
            'blog'  => 'nostro tutorial',
            'text'  => 'Hai bisogno di aiuto per configurare la Pagina Principale della tua campagna? Leggi :blog per trovare aiuto e ispirazione.',
        ],
        'widgets'   => [
            'calendar'      => 'Calendario',
            'campaign'      => 'Intestazione della campagna',
            'header'        => 'Intestazione testuale',
            'preview'       => 'Anteprima dell\'entità',
            'random'        => 'Entità casuale',
            'recent'        => 'Lista di entità',
            'unmentioned'   => 'Lista di entità non menzionate',
            'welcome'       => 'Benvenuto',
        ],
    ],
    'title'         => 'Pagina Principale',
    'widgets'       => [
        'advanced_options_boosted'  => 'Abilita altre opzioni, come mostrare i pin con una campagna :boosted_campaign.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Cambia la data al giorno successivo',
                'previous'  => 'Cambia la data al giorno precedente',
            ],
            'previous_events'   => 'Precedente',
            'upcoming_events'   => 'Prossimi',
        ],
        'campaign'                  => [
            'helper'    => 'Questo widget mostra l\'intestazione della campagna. Il widget è sempre visibile nella Pagina Principale predefinita.',
        ],
        'create'                    => [
            'success'   => 'Widget aggiunto alla Pagina Principale.',
        ],
        'delete'                    => [
            'success'   => 'Widget rimosso dalla Pagina Principale.',
        ],
        'fields'                    => [
            'class'             => 'classe CSS',
            'dashboard'         => 'Pagina Principale',
            'name'              => 'Nome personalizzato di widget',
            'optional-entity'   => 'Link all\'entità',
            'order'             => 'Ordinamento',
            'size'              => 'Dimensione',
            'width'             => 'Larghezza',
        ],
        'helpers'                   => [
            'class'     => 'Definisci una classe personalizzata CSS aggiunto al widget.',
            'filters'   => 'Clicca per imparare di più sulle opzioni di filtro disponibili.',
        ],
        'orders'                    => [
            'name_asc'  => 'Nome crescente',
            'name_desc' => 'Nome decrescente',
            'oldest'    => 'Non modificato da molto tempo',
            'recent'    => 'Modificato recentemente',
        ],
        'preview'                   => [
            'displays'  => [
                'expand'    => 'Voce espandibile',
                'full'      => 'Voce completa',
            ],
            'fields'    => [
                'display'   => 'Visualizza',
            ],
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Puoi fare riferimento al nome dell\'entità casuale con {name}',
            ],
            'type'      => [
                'all'   => 'Tutti',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtro avanzato',
            'advanced_filters'  => [
                'mentionless'   => 'Senza menzioni (entità che non menziona altre entità)',
                'unmentioned'   => 'Non menzionata (entità che non è menzionata da nessun altra)',
            ],
            'entity-header'     => 'Usa l\'intestazione dell\'entità come immagine',
            'filters'           => 'Filtri',
            'help'              => 'Visualizza solamente l\'ultima entità aggiornata, ma visualizza un\'anteprima completa per la stessa.',
            'helpers'           => [
                'entity-header'     => 'Se l\'entità ha un\'intestazione dell\'entità (caratteristica della campagna potenziata), imposta questo widget in modo che utilizzi quell\'immagine invece dell\'immagine dell\'entità.',
                'show_attributes'   => 'Mostra gli attributi appuntati dell\'entità sotto la voce.',
                'show_members'      => 'Se l\'entità è una famiglia o un\'organizzazione, indica i suoi membri sotto la voce.',
                'show_relations'    => 'Mostra le relazioni appuntate dell\'entità sotto la voce.',
            ],
            'show_attributes'   => 'Mostra gli attributi appuntati',
            'show_members'      => 'Mostra membri',
            'show_relations'    => 'Mostra relazioni fissate',
            'singular'          => 'Anteprima',
            'tags'              => 'Filtra la lista di entità con etichette specifiche.',
            'title'             => 'Lista di entità',
        ],
        'tabs'                      => [
            'advanced'  => 'Avanzato',
            'setup'     => 'Impostazione',
        ],
        'unmentioned'               => [
            'title' => 'Entità non menzionate',
        ],
        'update'                    => [
            'success'   => 'Widget modificato.',
        ],
        'widths'                    => [
            '0' => 'Automatica',
            '12'=> 'Intera (100%)',
            '3' => 'Minuscola (25%)',
            '4' => 'Piccola (33%)',
            '6' => 'Media (50%)',
            '8' => 'Larga (66%)',
            '9' => 'Grande (75%)',
        ],
    ],
];
