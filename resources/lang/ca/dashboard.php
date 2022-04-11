<?php

return [
    'actions'       => [
        'follow'    => 'Segueix',
        'join'      => 'Uneix-me',
        'unfollow'  => 'Deixa de seguir',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count mòduls',
            'roles'     => ':count rols',
            'users'     => ':count usuaris',
        ],
    ],
    'dashboards'    => [
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
    'helpers'       => [
        'follow'    => 'Les campanyes que seguiu apareixen al menú de canvi de campanya (adalt a l\'esquerra) sota les vostres campanyes.',
        'join'      => 'Aquesta campanya es troba oberta a nous membres. Cliqueu a "Uneix-me" per a sol·licitar unir-vos.',
        'setup'     => 'Configura el taulell de la campanya',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'D\'acord',
            'title'     => 'Notificació important',
        ],
    ],
    'recent'        => [
        'title' => ':name que s\'han modificat recentement',
    ],
    'settings'      => [
        'title' => 'Configuració del taulell',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Afegeix un widget',
            'back_to_dashboard' => 'Torna al taulell',
            'edit'              => 'Edita el widget',
        ],
        'title'     => 'Configura el taulell de la campanya',
        'tutorial'  => [
            'blog'  => 'el nostre tutorial',
            'text'  => 'Us cal ajuda per a configurar el tauler de la campanya? Al :blog hi trobareu ajuda i inspiració.',
        ],
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
    'title'         => 'Taulell de',
    'welcome'       => [],
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Opcions avançades',
            'delete-confirm'    => 'aquest widget',
        ],
        'advanced_options_boosted'  => 'Les :boosted_campaigns tenen opcions avançades, com ara mostrar els membres d\'una família o els atributs de l\'entitat directament al taulell.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Canvia la data al dia següent',
                'previous'  => 'Canvia la data al dia anterior',
            ],
            'events_today'      => 'Avui',
            'previous_events'   => 'Previ',
            'upcoming_events'   => 'Proper',
        ],
        'campaign'                  => [
            'helper'    => 'Aquest widget mostra la capçalera de la campanya i sempre es mostra al taulell per defecte.',
        ],
        'create'                    => [
            'success'   => 'S\'ha afegit el widget al taulell.',
        ],
        'delete'                    => [
            'success'   => 'S\'ha eliminat el widget del taulell.',
        ],
        'fields'                    => [
            'class'             => 'Classe CSS',
            'dashboard'         => 'Taulell',
            'name'              => 'Nom personalitzat pel widget',
            'optional-entity'   => 'Enllaç a l\'entitat',
            'order'             => 'Ordre',
            'text'              => 'Text',
            'width'             => 'Amplada',
        ],
        'helpers'                   => [
            'class' => 'Definiu una classe CSS personalitzada per afegir-la al widget.',
        ],
        'orders'                    => [
            'name_asc'  => 'Ascendent per nom',
            'name_desc' => 'Descendent per nom',
            'recent'    => 'Modificat recentment',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Podeu referenciar el nom de l\'entitat aleatòria amb {name}',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtre avançat',
            'advanced_filters'  => [
                'mentionless'   => 'Sense mencions (entitats que no en mencionen cap altra)',
                'unmentioned'   => 'Sense mencionar (entitats que no són mencionades a cap altra)',
            ],
            'entity-header'     => 'Utilitza la capçalera de l\'entitat com a imatge',
            'filters'           => 'Filtres',
            'full'              => 'Completa',
            'help'              => 'Mostra només la previsualització de l\'última entitat actualitzada.',
            'helpers'           => [
                'entity-header'     => 'Si l\'entitat té una capçalera (funcionalitat de campanyes millorades), podeu indicar que aquest widget la utilitzi en comptes de la imatge de l\'entitat.',
                'filters'           => 'Podeu filtrar quin tipus d\'entitats es mostren. Per saber-ne més, consulteu la pàgina d\'ajuda a :link.',
                'full'              => 'Mostra tota l\'entitat per defecte en comptes d\'una previsualització.',
                'show_attributes'   => 'Mostra els atributs de l\'entitat sota la descripció.',
                'show_members'      => 'Si l\'entitat és una família o una organització, mostra els seus membres sota la descripció.',
                'show_relations'    => 'Mostra les anotacions fixades sota l\'entrada de l\'entitat.',
            ],
            'show_attributes'   => 'Mostra els atributs',
            'show_members'      => 'Mostra els membres',
            'show_relations'    => 'Mostra les relacions fixades',
            'singular'          => 'Singular',
            'tags'              => 'Filtra la llista de les entitats modificades recentment amb etiquetes específiques.',
            'title'             => 'Modificades recentment',
        ],
        'tabs'                      => [
            'advanced'  => 'Avançat',
            'setup'     => 'Configuració',
        ],
        'unmentioned'               => [
            'title' => 'Entitats no mencionades',
        ],
        'update'                    => [
            'success'   => 'S\'ha modificat el widget.',
        ],
        'widths'                    => [
            '0' => 'Auto',
            '12'=> 'Completa (100%)',
            '3' => 'Quart (25%)',
            '4' => 'Terç (33%)',
            '6' => 'Meitat (50%)',
            '8' => 'Ampla (66%)',
            '9' => 'Gran (75%)',
        ],
    ],
];
