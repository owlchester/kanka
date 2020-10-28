<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Afegeix un personatge a la missió',
            'success'       => 'S\'ha afegit el personatge a :name.',
            'title'         => 'Nou personatge per a :name',
        ],
        'destroy'   => [
            'success'   => 'S\'ha tret el personatge de :name.',
        ],
        'edit'      => [
            'description'   => 'Actualiza un personatge de la missió',
            'success'       => 'S\'ha actualitzat el personatge de la missió :name.',
            'title'         => 'Actualitza el personatge de :name',
        ],
        'fields'    => [
            'character'     => 'Personatge',
            'description'   => 'Descripció',
        ],
        'title'     => 'Personatges a :name',
    ],
    'create'        => [
        'description'   => 'Crea una nova missió',
        'success'       => 'S\'ha creat la missió «:name».',
        'title'         => 'Nova missió',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la missió «:name».',
    ],
    'edit'          => [
        'description'   => 'Edita la missió',
        'success'       => 'S\'ha actualitzat la missió «:name».',
        'title'         => 'Edita la missió :name',
    ],
    'fields'        => [
        'character'     => 'Instigador',
        'characters'    => 'Personatges',
        'copy_elements' => 'Copia els elements vinculats a la missió',
        'date'          => 'Data',
        'description'   => 'Descripció',
        'image'         => 'Imatge',
        'is_completed'  => 'Completada',
        'items'         => 'Objectes',
        'locations'     => 'Indrets',
        'name'          => 'Nom',
        'organisations' => 'Organitzacions',
        'quest'         => 'Missió superior',
        'quests'        => 'Sub-missions',
        'role'          => 'Rol',
        'type'          => 'Tipus',
    ],
    'helpers'       => [
        'nested'    => 'Amb la vista niada, es poden veure les missions de forma agrupada. Les missions que no tinguin missió superior es mostraran per defecte. A les missions amb submisiones se\'ls pot clicar per a mostrar els seus descendents. Podeu seguir clicant fins que no hi hagi més descendents a mostrar.',
    ],
    'hints'         => [
        'quests'    => 'Es pot crear una xarxa de missions entrellaçades usant el camp de missió superior.',
    ],
    'index'         => [
        'add'           => 'Nova missió',
        'description'   => 'Gestiona les missions de :name.',
        'header'        => 'Missions de :name',
        'title'         => 'Missions',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Afegeix un objecte a la missió',
            'success'       => 'S\'ha afegit l\'objecte a :name.',
            'title'         => 'Nou objecte per a :name',
        ],
        'destroy'   => [
            'success'   => 'S\'ha tret l\'objecte de :name.',
        ],
        'edit'      => [
            'description'   => 'Actualiza un objecte de la missió',
            'success'       => 'S\'ha actualitzat l\'objecte de :name.',
            'title'         => 'Actualiza l\'objecte de :name',
        ],
        'fields'    => [
            'description'   => 'Descripció',
            'item'          => 'Objecte',
        ],
        'title'     => 'Objectes de :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Indica un indret per a la missió',
            'success'       => 'S\'ha afegit l\'indret a :name.',
            'title'         => 'Nou indret per a :name',
        ],
        'destroy'   => [
            'success'   => 'S\'ha tret l\'indret de la missió :name.',
        ],
        'edit'      => [
            'description'   => 'Actualiza la localització d\'una missió',
            'success'       => 'S\'ha actualitzat l\'indret de la missió :name.',
            'title'         => 'Actualiza la localització de :name',
        ],
        'fields'    => [
            'description'   => 'Descripció',
            'location'      => 'Indret',
        ],
        'title'     => 'Indrets de :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Afegeix una organització a la missió',
            'success'       => 'S\'ha afegit l\'organització a :name.',
            'title'         => 'Nova organització per a :name',
        ],
        'destroy'   => [
            'success'   => 'S\'ha tret l\'organització de la missió :name.',
        ],
        'edit'      => [
            'description'   => 'Actualiza una organització de la missió',
            'success'       => 'S\'ha actualitzat l\'organització de la missió :name.',
            'title'         => 'Actualitza l\'organització de :name',
        ],
        'fields'    => [
            'description'   => 'Descripció',
            'organisation'  => 'Organització',
        ],
        'title'     => 'Organitzacions a :name',
    ],
    'placeholders'  => [
        'date'  => 'Data real de la missió',
        'name'  => 'Nom de la missió',
        'quest' => 'Missió superior',
        'role'  => 'El paper que juga l\'entitat a la missió',
        'type'  => 'Història principal, arc de personatge, missió secundària...',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Afegeix un personatge',
            'add_item'          => 'Afegeix un objecte',
            'add_location'      => 'Afegeix una localització',
            'add_organisation'  => 'Afegeix una organització',
        ],
        'description'   => 'Vista detallada de la missió',
        'tabs'          => [
            'characters'    => 'Personatges',
            'information'   => 'Informació',
            'items'         => 'Objectes',
            'locations'     => 'Indrets',
            'organisations' => 'Organitzacions',
            'quests'        => 'Missions',
        ],
        'title'         => 'Missió :name',
    ],
];
