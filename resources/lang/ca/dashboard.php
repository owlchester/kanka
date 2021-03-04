<?php

return [
    'actions'           => [
        'follow'    => 'Segueix',
        'join'      => 'Uneix-me',
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
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Edita',
            'new'       => 'Nou taulell',
            'switch'    => 'Canvia de taulell',
        ],
        'boosted'       => 'Les :boosted_campaigns poden crear taulells personalitzats per a cadascun dels rols de la campanya.',
        'create'        => [
            'success'   => 'S\'ha creat el nou taulell :name.',
            'title'     => 'Nou taulell de campanya',
        ],
        'custom'        => [
            'text'  => 'Esteu editant el taulell :name de la campanya.',
        ],
        'default'       => [
            'text'  => 'Esteu editant el taulell per defecte de la campanya.',
            'title' => 'Taulell per defecte',
        ],
        'delete'        => [
            'success'   => 'S\'ha eliminat el taulell :name.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copia els widgets',
            'name'          => 'Nom del taulell',
            'visibility'    => 'Visibilitat',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplica els widgets del taulell :name cap a aquest.',
        ],
        'placeholders'  => [
            'name'  => 'Nom del taulell',
        ],
        'update'        => [
            'success'   => 'S\'ha actualitzat el talell :name.',
            'title'     => 'Actualitzar el taulell :name',
        ],
        'visibility'    => [
            'default'   => 'Per defecte',
            'none'      => 'Cap',
            'visible'   => 'Visible',
        ],
    ],
    'description'       => 'La llar de la creativitat',
    'helpers'           => [
        'follow'    => 'Les campanyes que seguiu apareixen al menú de canvi de campanya (adalt a l\'esquerra) sota les vostres campanyes.',
        'join'      => 'Aquesta campanya es troba oberta a nous membres. Cliqueu a "Uneix-me" per a sol·licitar unir-vos.',
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
            'campaign'      => 'Encapçalament de la campanya',
            'header'        => 'Capçalera',
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
        'campaign'      => [
            'helper'    => 'Aquest giny mostra la capçalera de la campanya i sempre es mostra al taulell per defecte.',
        ],
        'create'        => [
            'success'   => 'Giny afegit al taulell.',
        ],
        'delete'        => [
            'success'   => 'Giny eliminat del taulell.',
        ],
        'fields'        => [
            'name'  => 'Nom de giny personalitzat',
            'text'  => 'Text',
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
