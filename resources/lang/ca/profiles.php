<?php

return [
    'avatar'        => [
        'success'   => 'S\'ha actualitzat l\'avatar.',
    ],
    'description'   => 'Actualitza els detalls del perfil',
    'edit'          => [
        'success'   => 'S\'ha actualitzat el perfil.',
    ],
    'editors'       => [
        'default'       => 'Per defecte (TinyMCE 4)',
        'summernote'    => 'Experimental (Summernote)',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Adreça electrònica',
        'last_login_share'          => 'Comparteix l\'última vegada que vaig estar en línia amb altres membres de la campanya.',
        'name'                      => 'Nom',
        'new_password'              => 'Contrasenya nova',
        'new_password_confirmation' => 'Confirma la nova contrasenya',
        'newsletter'                => 'M\'agradaria rebre notícies del web per correu electrònic.',
        'password'                  => 'Contrasenya actual',
        'settings'                  => 'Configuració',
        'theme'                     => 'Tema',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Votació comunitària',
            'news'              => 'Novetats',
        ],
        'settings'  => [
            'news'          => 'Novetats - Notifica\'m quan hi hagi :news',
            'newsletter'    => 'Newsletter - Rep la newsletter de Kanka',
            'votes'         => 'Votacions comunitàrias - Notifica\'m quan una nova :vote estigui disponible',
        ],
        'title'     => 'Newsletters',
    ],
    'password'      => [
        'success'   => 'S\'ha actualitzat la contrasenya.',
    ],
    'placeholders'  => [
        'email'                     => 'La vostra adreça electrònica',
        'name'                      => 'El vostre nom d\'usuari',
        'new_password'              => 'La nova contrasenya',
        'new_password_confirmation' => 'Confirmeu la nova contrasenya',
        'password'                  => 'Escriviu la contrasenya actual per a aplicar els canvis',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Elimina el compte',
            'title'     => 'Eliminació del compte',
            'warning'   => 'En eliminar el compte, totes les vostres dades s\'esborraran. N\'esteu segur?',
        ],
        'password'  => [
            'title' => 'Canvi de contrasenya',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Mencions avançades',
            'date_format'           => 'Format de data',
            'default_nested'        => 'Vista niada per defecte',
            'editor'                => 'Editor de text',
            'new_entity_workflow'   => 'Nou flux de treball',
            'pagination'            => 'Paginació (elements per pàgina)',
        ],
        'helpers'   => [
            'editor'    => 'L\'editor de text per defecte (TinyMCE 4) és antic però funciona bé en escriptori, encara que no en mòbil. Summernote és un editor més nou que funciona a tots els dispositius, però encara l\'estem provant.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'En activar-ho, les mencions sempre es renderitzaran com a [entity:123] en editar una entitat.',
            'default_nested'        => 'Activeu aquesta opció perquè les llistes estiguin en vista niada per defecte (quan sigui possible).',
            'new_entity_workflow'   => 'En crear una entitat nova, per defecte es redirigeix a la lista d\'entitats. Enlloc d\'això, podeu canviar-ho per a anar a l\'entitat que acabeu de crear.',
        ],
        'success'   => 'S\'ha canviat la configuració.',
    ],
    'theme'         => [
        'success'   => 'S\'ha canviat el tema.',
        'themes'    => [
            'dark'      => 'Fosc',
            'default'   => 'Per defecte',
            'future'    => 'Futur',
            'midnight'  => 'Blau mitjanit',
        ],
    ],
    'title'         => 'Actualitza el perfil',
    'workflows'     => [
        'created'   => 'Anar a l\'entitat nova',
        'default'   => 'Llista d\'entitats',
    ],
];
