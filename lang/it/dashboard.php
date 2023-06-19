<?php

return [
    'actions'       => [
        'follow'    => 'Segui',
        'join'      => 'Unisciti',
        'unfollow'  => 'Smetti di seguire',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count Moduli',
            'roles'     => ':count Ruoli',
            'users'     => ':count Utenti',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Modifica nomi & permessi',
            'new'       => 'Nuova Dashboard',
            'switch'    => 'Cambia in Dashboard',
        ],
        'create'        => [
            'success'   => 'Nuova Dashboard della campagna :name creato.',
            'title'     => 'Nuova Dashboard della campagna',
        ],
        'custom'        => [
            'text'  => 'Stai modificando il :name Dashboard della campagna.',
        ],
        'default'       => [
            'text'  => 'Stai modificando la Dashboard predefinita della campagna.',
            'title' => 'Dashboard Predefinita',
        ],
        'delete'        => [
            'success'   => 'Dashboard :nome rimossa.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copia widgets',
            'name'          => 'Nome Dashboard',
            'visibility'    => 'Visibilità',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplica i widgets dalla Dashboard :name a questa nuova.',
        ],
        'pitch'         => 'Crea multiple Dashboard con permessi personalizzati per ogni ruolo all\'interno della campagna.',
        'placeholders'  => [
            'name'  => 'Nome della Dashboard',
        ],
        'update'        => [
            'success'   => 'Dashboard  della campagna :name aggiornata.',
            'title'     => 'Aggiorna la Dashboard della campagna :name.',
        ],
        'visibility'    => [
            'default'   => 'Predefinito',
            'none'      => 'Nessuno',
            'visible'   => 'Visibile',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Seguire una campagna farà si che questa appaia nel selettore delle campagne (in alto a destra) sotto alle tue campagna.',
        'join'      => 'Questa campagna è aperta a nuovi membri. Clicca per unirti.',
        'setup'     => 'Imposta la dashboard della tua campagna.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Capito',
            'title'     => 'Notifica iImportante',
        ],
    ],
    'recent'        => [
        'title' => ':name con modifiche recenti',
    ],
    'settings'      => [
        'title' => 'Impostazioni della Dashboard',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Aggiungi un widget',
            'back_to_dashboard' => 'Torna alla dashboard',
            'edit'              => 'Modifica un widget',
            'new'               => 'Nuovo :type widget',
        ],
        'reorder'   => [
            'success'   => 'Widgets riordinati.',
        ],
        'title'     => 'Impostazioni della Dashboard della Campagna',
        'tutorial'  => [
            'blog'  => 'nostra guida',
            'text'  => 'Hai bisogno di aiuto per configurare il cruscotto della tua campagna? Leggi :blog per trovare un aiuto e dell\'ispirazione.',
        ],
        'widgets'   => [
            'calendar'      => 'Calendario',
            'campaign'      => 'Intestazione della campagna',
            'header'        => 'Testo dell\'intestazione',
            'preview'       => 'Anteprima Entità',
            'random'        => 'Entità casuale',
            'recent'        => 'Recente',
            'unmentioned'   => 'Lista di entità non citate',
            'welcome'       => 'Benvenuto',
        ],
    ],
    'title'         => 'Dashboard',
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Opzioni avanzate',
        ],
        'advanced_options_boosted'  => 'Abilita più opzioni come mostra messaggi attaccati con una :boosted_campaign.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Cambia la data al giorno successivo',
                'previous'  => 'Cambia la data al giorno precedente',
            ],
            'events_today'      => 'Oggi',
            'previous_events'   => 'Precedente',
            'upcoming_events'   => 'Successivo',
        ],
        'campaign'                  => [
            'helper'    => 'Questo widget mostra l\'intestazione della campagna. Il widget è sempre visibile nella Dashboard predefinita.',
        ],
        'create'                    => [
            'success'   => 'Widget aggiunto alla dashboard',
        ],
        'delete'                    => [
            'success'   => 'Widget rimosso dalla dashboard',
        ],
        'fields'                    => [
            'class'             => 'Classe CSS',
            'dashboard'         => 'Dashboard',
            'name'              => 'Personalizza il nome del widget',
            'optional-entity'   => 'Link ad entità',
            'order'             => 'Ordinare',
            'size'              => 'Dimensione',
            'text'              => 'Testo',
            'width'             => 'Larghezza',
        ],
        'helpers'                   => [
            'class'     => 'Definisci una classe css personalizzata da aggiungere al widget.',
            'filters'   => 'Clicca per scoprire i filtri disponibili',
        ],
        'orders'                    => [
            'name_asc'  => 'Nome crescente',
            'name_desc' => 'Nome decrescente',
            'recent'    => 'Modificato di recente',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Puoi fare riferimento al nome dell\'entità casuale con {name}',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtri avanzati',
            'advanced_filters'  => [
                'mentionless'   => 'Senza citazioni (entità che non menziona altre entità)',
                'unmentioned'   => 'Non citata (entità che non è menzionata da nessun altra)',
            ],
            'entity-header'     => 'Usa l\'intestazione dell\'entità come immagine',
            'filters'           => 'Filtri',
            'help'              => 'Visualizza solamente l\'ultima entità aggiornata, ma visualizza un\'antemprima completa per la stessa.',
            'helpers'           => [
                'entity-header'     => 'Se l\'entità ha un\'intestazione dell\'entità (funzione della campagna potenziata), imposta questo widget in modo che utilizzi quell\'immagine invece dell\'immagine dell\'entità.',
                'show_attributes'   => 'Mostra gli attributi appuntati dell\'entità sotto la voce.',
                'show_members'      => 'Se l\'entità è una famiglia o un\'organizzazione, indica i suoi membri sotto la voce.',
                'show_relations'    => 'Mostra le relazioni appuntate dell\'entità sotto la voce.',
            ],
            'show_attributes'   => 'Mostra gli attributi appuntati.',
            'show_members'      => 'Mostra membri',
            'show_relations'    => 'Mostra le relazioni appuntate',
            'singular'          => 'Singola',
            'tags'              => 'Filtra la lista dell\'entità con tags specifici',
            'title'             => 'Modificati di recente',
        ],
        'tabs'                      => [
            'advanced'  => 'Avanzati',
            'setup'     => 'Configurazione',
        ],
        'unmentioned'               => [
            'title' => 'Entità non citate',
        ],
        'update'                    => [
            'success'   => 'Widget modificato.',
        ],
        'welcome'                   => [
            'helper'    => 'Questo widget visualizza un messaggio di benvenuto sulla Dashboard che include link utili per i nuovi utenti di Kanka.',
        ],
        'widths'                    => [
            '0' => 'Automatica',
            '12'=> 'Intera',
            '3' => 'Minuscola (25%)',
            '4' => 'Piccola (33%)',
            '6' => 'Media (50%)',
            '8' => 'Ampia (66%)',
            '9' => 'Larga (75%)',
        ],
    ],
];
