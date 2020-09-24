<?php

return [
    'actions'           => [
        'follow'    => 'Segueix',
        'unfollow'  => 'Deixa de seguir',
    ],
    'campaigns'         => [
        'manage'    => 'Gestiona la campaña',
        'tabs'      => [
            'modules'   => ':count mòduls',
            'roles'     => ':count rols',
            'users'     => ':count usuaris',
        ],
    ],
    'description'       => 'La llar de la creativitat',
    'helpers'           => [
        'follow'    => 'Les campanyes que seguiu apareixen al menú de canvi de campanya (adalt a l\'esquerra) sota les vostres campanyes.',
        'setup'     => 'Configura el taulell de la campanya',
    ],
    'latest_release'    => 'Últim llançament',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'D\'acord',
            'title'     => 'Notificació important',
        ],
    ],
    'recent'            => [
        'add'           => 'Crea un nou :name',
        'no_entries'    => 'Actualment no hi ha entrades d\'aquest tipus.',
        'title'         => ':name que s\'han modificat recentement',
        'view'          => 'Veu tots els :name',
    ],
    'settings'          => [
        'description'   => 'Personalitza la vista del taulell',
        'edit'          => [
            'success'   => 'S\'han desat les modificacions.',
        ],
        'fields'        => [
            'helper'        => 'Es pot canviar fàcilment la vista del taulell. Tingueu en compte que totes les campanyes es veuran afectades, independentement de la configuració d\'aquestes.',
            'recent_count'  => 'Nombre d\'elements recents',
        ],
        'title'         => 'Configuració del taulell',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Afegeix un giny',
            'back_to_dashboard' => 'Torna al taulell',
            'edit'              => 'Edita el giny',
        ],
        'title'     => 'Configura el taulell de la campanya',
        'widgets'   => [
            'calendar'      => 'Calendari',
            'preview'       => 'Previsualització de l\'entitat',
            'random'        => 'Entitat aleatòria',
            'recent'        => 'Recent',
            'unmentioned'   => 'Entitat no mencionada',
        ],
    ],
    'title'             => 'Taulell de',
    'welcome'           => [],
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Canvia la data al dia següent',
                'previous'  => 'Canvia la data al dia anterior',
            ],
            'events_today'      => 'Avui',
            'previous_events'   => 'Previ',
            'upcoming_events'   => 'Proper',
        ],
        'create'        => [
            'success'   => 'Giny afegit al taulell.',
        ],
        'delete'        => [
            'success'   => 'Giny eliminat del taulell.',
        ],
        'fields'        => [
            'width' => 'Amplada',
        ],
        'recent'        => [
            'entity-header' => 'Utilitza la capçalera de l\'entitat com a imatge',
            'full'          => 'Completa',
            'help'          => 'Mostra només la previsualització de l\'última entitat actualitzada.',
            'helpers'       => [
                'entity-header' => 'Si l\'entitat té una capçalera (funcionalitat de campanyes millorades), podeu indicar que aquest giny la utilitzi en comptes de la imatge de l\'entitat.',
                'full'          => 'Mostra tota l\'entitat per defecte en comptes d\'una previsualització.',
            ],
            'singular'      => 'Singular',
            'tags'          => 'Filtra la llista de les entitats modificades recentment amb etiquetes específiques.',
            'title'         => 'Modificades recentment',
        ],
        'unmentioned'   => [
            'title' => 'Entitats no mencionades',
        ],
        'update'        => [
            'success'   => 'Giny modificat.',
        ],
        'widths'        => [
            '0' => 'Auto',
            '12'=> 'Completa (100%)',
            '3' => 'Quart (25%)',
            '4' => 'Terç (33%)',
            '6' => 'Meitat (50%)',
            '8' => 'Ampla (66%)',
        ],
    ],
];
