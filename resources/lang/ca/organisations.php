<?php

return [
    'create'        => [
        'description'   => 'Crea una nova organització',
        'success'       => 'S\'ha creat l\'organització «:name».',
        'title'         => 'Nova organització',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'organització «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'organització «:name».',
        'title'     => 'Edita l\'organització :name',
    ],
    'fields'        => [
        'image'         => 'Imatge',
        'location'      => 'Indret',
        'members'       => 'Membres',
        'name'          => 'Nom',
        'organisation'  => 'Organització superior',
        'organisations' => 'Suborganitzacions',
        'relation'      => 'Relació',
        'type'          => 'Tipus',
    ],
    'helpers'       => [
        'descendants'   => 'Aquí es mostren totes les organitzacions que descendeixen d\'aquesta organització, no només les directament inferiors.',
        'nested'        => 'Amb la vista niada, es poden veure les organitzacions de forma agrupada. Les organitzacions que no tinguin organització superior es mostraran per defecte. Cliqueu les organitzacions amb suborganizaciones per a mostrar els seus descendents. Es pot seguir clicant fins que no hi hagi més descendents a mostrar.',
    ],
    'index'         => [
        'add'           => 'Nova organització',
        'description'   => 'Gestiona les organitzacions de :name.',
        'header'        => 'Organitzacions de :name',
        'title'         => 'Organitzacions',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Afegeix un membre',
        ],
        'create'        => [
            'description'   => 'Afegeix un membre a l\'organització',
            'success'       => 'S\'ha afegit el membre a l\'organització.',
            'title'         => 'Nou membre de :name',
        ],
        'destroy'       => [
            'success'   => 'S\'ha tret el membre de l\'organització.',
        ],
        'edit'          => [
            'success'   => 'S\'ha actualitzat el membre de l\'organització.',
            'title'     => 'Actualitza un membre de :name',
        ],
        'fields'        => [
            'character'     => 'Personatge',
            'organisation'  => 'Organització',
            'role'          => 'Rol',
        ],
        'helpers'       => [
            'all_members'   => 'Tots els personatges que pertanyen a aquesta organització i les seves suborganitzacions.',
            'members'       => 'Tots els membres que pertanyen a aquesta organització.',
        ],
        'placeholders'  => [
            'character' => 'Trieu un personatge',
            'role'      => 'Líder, membre, Mestre d\'espies, Septó Suprem...',
        ],
        'title'         => 'Membres de :name',
    ],
    'organisations' => [
        'title' => 'Organitzacions de :name',
    ],
    'placeholders'  => [
        'location'  => 'Trieu un indret',
        'name'      => 'Nom de l\'organització',
        'type'      => 'Secta, banda, rebel·lió, gremi...',
    ],
    'quests'        => [
        'description'   => 'Missions on participa l\'organització.',
        'title'         => 'Missions de :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada de l\'organització',
        'tabs'          => [
            'organisations' => 'Organitzacions',
            'quests'        => 'Missions',
            'relations'     => 'Relacions',
        ],
        'title'         => 'Organització :name',
    ],
];
