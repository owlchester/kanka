<?php

return [
    'create'        => [
        'description'   => 'Crea una nova conversa',
        'success'       => 'S\'ha creat la conversa «:name».',
        'title'         => 'Nova conversa',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la conversa «:name».',
    ],
    'edit'          => [
        'description'   => 'Actualiza la conversa',
        'success'       => 'S\'ha actualitzat la conversa «:name».',
        'title'         => 'Conversa :name',
    ],
    'fields'        => [
        'messages'      => 'Missatges',
        'name'          => 'Nom',
        'participants'  => 'Participants',
        'target'        => 'Objectiu',
        'type'          => 'Tipus',
    ],
    'hints'         => [
        'participants'  => 'Afegiu participants a la conversa clicant a la icona :icon adalt a la dreta.',
    ],
    'index'         => [
        'add'           => 'Nova conversa',
        'description'   => 'Gestiona les converses de :name.',
        'header'        => 'Converses de :name',
        'title'         => 'Converses',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'S\'ha eliminat el missatge.',
        ],
        'is_updated'    => 'Actualizat',
        'load_previous' => 'Carrega els missatges previs',
        'placeholders'  => [
            'message'   => 'El vostre missatge',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => 'S\'ha afegit el participant :entity a la conversa.',
        ],
        'description'   => 'Afegeix o elimina participants d\'una conversa',
        'destroy'       => [
            'success'   => 'El participant :entity s\'ha tret de la conversa.',
        ],
        'modal'         => 'Participants',
        'title'         => 'Participants de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la conversa',
        'type'  => 'Dins del joc, preparació, argument...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de conversa',
        'title'         => 'Conversa :name',
    ],
    'tabs'          => [
        'conversation'  => 'Conversa',
        'participants'  => 'Participants',
    ],
    'targets'       => [
        'characters'    => 'Personatges',
        'members'       => 'Membres',
    ],
];
