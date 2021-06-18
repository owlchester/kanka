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
        'legacy'        => 'Obsolet (TinyMCE 4)',
        'summernote'    => 'Summernote',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Adreça electrònica',
        'hide_subscription'         => 'Amaga el meu nom del :hall_of_fame.',
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
            'updates'           => 'Actualitzacions de Kanka',
        ],
        'settings'  => [
            'news'          => 'Novetats - Notifica\'m quan hi hagi :news',
            'newsletter'    => 'Newsletter - Rep la newsletter de Kanka',
            'updates'       => 'Actualitzacions: rebreu una notificació quan Kanka s\'actualitzi.',
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
            'helper'    => 'En eliminar el compte s\'eliminaran també les campanyes on en sigueu l\'únic membre. Aquesta acció és permanent i no es pot desfer.',
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
            'editor_v2' => 'L\'editor de text obsolet (TinyMCE) no suporta mencions als dispositius mòbils, i no té suport per a funcionalitats com la galeria de campanya.',
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
