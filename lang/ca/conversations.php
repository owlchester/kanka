<?php

return [
    'create'        => [
        'title' => 'Nova conversa',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Conversa :name',
    ],
    'fields'        => [
        'is_closed'     => 'Tancada',
        'messages'      => 'Missatges',
        'participants'  => 'Participants',
    ],
    'hints'         => [
        'participants'  => 'Afegiu participants a la conversa clicant a la icona :icon adalt a la dreta.',
    ],
    'index'         => [],
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
        'create'    => [
            'success'   => 'S\'ha afegit el participant :entity a la conversa.',
        ],
        'destroy'   => [
            'success'   => 'El participant :entity s\'ha tret de la conversa.',
        ],
        'modal'     => 'Participants',
        'title'     => 'Participants de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la conversa',
        'type'  => 'Dins del joc, preparació, argument...',
    ],
    'show'          => [
        'is_closed' => 'La conversa és tancada.',
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
