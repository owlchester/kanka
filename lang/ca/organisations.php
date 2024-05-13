<?php

return [
    'create'        => [
        'title' => 'Nova organització',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'members'   => 'Membres',
    ],
    'helpers'       => [],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'   => 'Afegeix un membre',
        ],
        'create'        => [
            'success'   => 'S\'ha afegit el membre a l\'organització.',
            'title'     => 'Nou membre de :name',
        ],
        'destroy'       => [
            'success'   => 'S\'ha tret el membre de l\'organització.',
        ],
        'edit'          => [
            'success'   => 'S\'ha actualitzat el membre de l\'organització.',
            'title'     => 'Actualitza un membre de :name',
        ],
        'fields'        => [
            'role'  => 'Rol',
        ],
        'helpers'       => [
            'all_members'   => 'Tots els personatges que pertanyen a aquesta organització i les seves suborganitzacions.',
            'members'       => 'Tots els membres que pertanyen a aquesta organització.',
        ],
        'placeholders'  => [
            'role'  => 'Líder, membre, Mestre d\'espies, Septó Suprem...',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Secta, banda, rebel·lió, gremi...',
    ],
    'quests'        => [],
    'show'          => [],
];
