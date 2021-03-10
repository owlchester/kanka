<?php

return [
    'actions'           => [
        'follow'    => 'Prati',
        'join'      => 'Pridruži se',
        'unfollow'  => 'Prekini pratiti',
    ],
    'campaigns'         => [
        'tabs'  => [
            'modules'   => '{1} :count modul|{2,*} :count modula',
            'roles'     => '{1} :count uloga|{2,4} :count uloge|{5,*} :count uloga',
            'users'     => '{1} :count korisnik|{2,*} :count korisnika',
        ],
    ],
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Uredi',
            'new'       => 'Nova naslovna ploča',
            'switch'    => 'Prebaci na naslovnu ploču',
        ],
        'boosted'       => ':boosted_campaigns mogu stvoriti prilagođene naslovne ploče za svaku od uloga kampanje.',
        'create'        => [
            'success'   => 'Kreirana nova naslovna ploča :name.',
            'title'     => 'Nova naslovna ploča',
        ],
        'custom'        => [
            'text'  => 'Trenutno uređuješ naslovnu ploču :name.',
        ],
        'default'       => [
            'text'  => 'Trenutno uređuješ zadanu naslovnu ploču.',
            'title' => 'Zadana naslovna ploča',
        ],
        'delete'        => [
            'success'   => 'Uklonjena naslovna ploča :name.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Kopiraj programčiće',
            'name'          => 'Naziv naslovne ploče',
            'visibility'    => 'Vidljivost',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Dupliciraj programčiće s nadzorne ploče :name u ovu novu.',
        ],
        'placeholders'  => [
            'name'  => 'Naziv naslovne ploče',
        ],
        'update'        => [
            'success'   => 'Ažurirana naslovna ploča :name',
            'title'     => 'Ažuriraj nadzornu ploču :name',
        ],
        'visibility'    => [
            'default'   => 'Zadana',
            'none'      => 'Nema',
            'visible'   => 'Vidljiva',
        ],
    ],
    'description'       => 'Dom za tvoju kreativnost',
    'helpers'           => [
        'follow'    => 'Praćenje kampanje prikazat će ju u izborniku kampanje (gore desno) ispod tvojih kampanja.',
        'join'      => 'Ova kampanja otvorena je za nove članove. Prijavi se da bi joj se pridružio/la.',
        'setup'     => 'Postavljanje naslovne ploče kampanje.',
    ],
    'latest_release'    => 'Najnovije izdanje',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Shvaćam',
            'title'     => 'Važna obavijest',
        ],
    ],
    'recent'            => [
        'title' => 'Nedavno izmijenjeno :name',
    ],
    'settings'          => [
        'title' => 'Postavke naslovne ploče',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Dodajte programčić',
            'back_to_dashboard' => 'Povratak na naslovnu ploču',
            'edit'              => 'Uredi programčić',
        ],
        'title'     => 'Postavljanje naslovne ploče kampanje',
        'widgets'   => [
            'calendar'      => 'Kalendar',
            'campaign'      => 'Zaglavlje kampanje',
            'header'        => 'Zaglavlje',
            'preview'       => 'Skraćeni pregled entiteta',
            'random'        => 'Nasumični entitet',
            'recent'        => 'Nedavno',
            'unmentioned'   => 'Entiteti koji nisu nigdje spomenuti',
        ],
    ],
    'title'             => 'Naslovna ploča',
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Promijeni trenutni datum na sljedeći dan',
                'previous'  => 'Promijeni trenutni datum na prethodni dan',
            ],
            'events_today'      => 'Danas',
            'previous_events'   => 'Prošli događaji',
            'upcoming_events'   => 'Nadolazeći događaji',
        ],
        'campaign'      => [
            'helper'    => 'Ovaj programčić prikazuje zaglavlje kampanje i uvijek se prikazuje zadanoj nadzornoj ploči.',
        ],
        'create'        => [
            'success'   => 'Programčić dodan na naslovnu ploču.',
        ],
        'delete'        => [
            'success'   => 'Programčić uklonjen s naslovne ploče.',
        ],
        'fields'        => [
            'name'  => 'Proizvoljan naziv programčića',
            'text'  => 'Tekst',
            'width' => 'Širina',
        ],
        'recent'        => [
            'entity-header' => 'Koristi zaglavlje entiteta kao sliku',
            'full'          => 'Puna',
            'help'          => 'Prikaži samo posljednji ažurirani entitet, ali prikaži cijeli pregled entiteta',
            'helpers'       => [
                'entity-header' => 'Ako entitet ima zaglavlje entiteta (značajka pojačane kampanje), postavite ovaj programčić da koristi tu sliku umjesto slike entiteta.',
                'full'          => 'Prikaži unos cijelog entiteta umjesto skraćenog pregleda.',
            ],
            'singular'      => 'Jedan',
            'tags'          => 'Filtrirajte popis nedavno izmijenjenih entiteta po navedenim oznakama.',
            'title'         => 'Nedavno izmijenjeno',
        ],
        'unmentioned'   => [
            'title' => 'Entiteti koji nisu nigdje spomenuti',
        ],
        'update'        => [
            'success'   => 'Programčić ažuriran.',
        ],
        'widths'        => [
            '0' => 'Automatski',
            '12'=> 'Puna (100%)',
            '3' => 'Sićušna (25%)',
            '4' => 'Mala (33%)',
            '6' => 'Pola (50%)',
            '8' => 'Široko (66%)',
        ],
    ],
];
