<?php

return [
    'actions'           => [
        'follow'    => 'Prati',
        'unfollow'  => 'Prekini pratiti',
    ],
    'campaigns'         => [
        'manage'    => 'Upravljanje kampanjom',
        'tabs'      => [
            'modules'   => ':count modula',
            'roles'     => ':count uloga',
            'users'     => ':count korisnika',
        ],
    ],
    'description'       => 'Dom za tvoju kreativnost',
    'helpers'           => [
        'follow'    => 'Praćenje kampanje prikazat će ju u izborniku kampanje (gore desno) ispod tvojih kampanja.',
        'setup'     => 'Postavljanje pregledne ploče kampanje.',
    ],
    'latest_release'    => 'Najnovije izdanje',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Shvaćam',
            'title'     => 'Važna obavijest',
        ],
    ],
    'recent'            => [
        'add'           => 'Kreiraj :name',
        'no_entries'    => 'Trenutno nema unosa ove vrste.',
        'title'         => 'Nedavno izmijenjeno :name',
        'view'          => 'Pregledaj sve :name',
    ],
    'settings'          => [
        'description'   => 'Prilagodi što vidiš na preglednoj ploči',
        'edit'          => [
            'success'   => 'Tvoje promjene su spremljene.',
        ],
        'fields'        => [
            'helper'        => 'Možeš jednostavno promijeniti ono što vidiš na nadzornoj ploči. Imaj na umu da je to za sve tvoje kampanje, bez obzira na postavke kampanje.',
            'recent_count'  => 'Broj nedavnih elemenata',
        ],
        'title'         => 'Postavke pregledne ploče',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Dodajte programčić',
            'back_to_dashboard' => 'Povratak na preglednu ploču',
            'edit'              => 'Uredi programčić',
        ],
        'title'     => 'Postavljanje pregledne ploče kampanje',
        'widgets'   => [
            'calendar'  => 'Kalendar',
            'preview'   => 'Skraćeni pregled entiteta',
            'recent'    => 'Nedavno',
        ],
    ],
    'title'             => 'Pregledna ploča',
    'widgets'           => [
        'calendar'  => [
            'actions'           => [
                'next'      => 'Promijeni datum na sljedeći dan',
                'previous'  => 'Promijeni datum u prethodni dan',
            ],
            'events_today'      => 'Danas',
            'previous_events'   => 'Prethodni',
            'upcoming_events'   => 'Sljedeći',
        ],
        'create'    => [
            'success'   => 'Programčić dodan na preglednu ploču.',
        ],
        'delete'    => [
            'success'   => 'Programčić uklonjen s pregledne ploče.',
        ],
        'fields'    => [
            'width' => 'Širina',
        ],
        'recent'    => [
            'full'      => 'Puna',
            'help'      => 'Prikaži samo posljednji ažurirani entitet, ali prikaži cijeli pregled entiteta',
            'helpers'   => [
                'full'  => 'Prikaži unos cijelog entiteta umjesto skraćenog pregleda.',
            ],
            'singular'  => 'Jedan',
            'title'     => 'Nedavno izmijenjeno',
        ],
        'update'    => [
            'success'   => 'Programčić ažuriran.',
        ],
        'widths'    => [
            '0' => 'Automatski',
            '12'=> 'Puna',
            '4' => 'Mala',
            '6' => 'Pola',
        ],
    ],
];
