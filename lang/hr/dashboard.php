<?php

return [
    'actions'       => [
        'follow'    => 'Prati',
        'join'      => 'Pridruži se',
        'unfollow'  => 'Prekini pratiti',
    ],
    'campaigns'     => [],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Uredi',
            'new'       => 'Nova naslovna ploča',
            'switch'    => 'Prebaci na naslovnu ploču',
        ],
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
    'helpers'       => [
        'follow'    => 'Praćenje kampanje prikazat će ju u izborniku kampanje (gore desno) ispod tvojih kampanja.',
        'join'      => 'Ova kampanja otvorena je za nove članove. Prijavi se da bi joj se pridružio/la.',
    ],
    'notifications' => [],
    'recent'        => [],
    'settings'      => [],
    'setup'         => [
        'actions'   => [
            'add'               => 'Dodajte programčić',
            'back_to_dashboard' => 'Povratak na naslovnu ploču',
            'edit'              => 'Uredi programčić',
        ],
        'title'     => 'Postavljanje naslovne ploče kampanje',
    ],
    'title'         => 'Naslovna ploča',
    'widgets'       => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Promijeni trenutni datum na sljedeći dan',
                'previous'  => 'Promijeni trenutni datum na prethodni dan',
            ],
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
            'dashboard' => 'Naslovna ploča',
            'name'      => 'Proizvoljan naziv programčića',
            'order'     => 'Sortiranje',
            'width'     => 'Širina',
        ],
        'orders'        => [
            'name_asc'  => 'Po imenu uzlazno',
            'name_desc' => 'Po imenu silazno',
            'recent'    => 'Nedavno izmijenjeno',
        ],
        'random'        => [
            'helpers'   => [
                'name'  => 'Možeš referencirati nasumičan entitet s {ime}.',
            ],
        ],
        'recent'        => [
            'entity-header'     => 'Koristi zaglavlje entiteta kao sliku',
            'filters'           => 'Filteri',
            'help'              => 'Prikaži samo posljednji ažurirani entitet, ali prikaži cijeli pregled entiteta',
            'helpers'           => [
                'entity-header'     => 'Ako entitet ima zaglavlje entiteta (značajka pojačane kampanje), postavite ovaj programčić da koristi tu sliku umjesto slike entiteta.',
                'show_attributes'   => 'Prikaži prikvačene atribute entiteta ispod unosa.',
                'show_members'      => 'Ako je entitet obitelj ili organizacija, pokaži njezine članove ispod unosa.',
                'show_relations'    => 'Prikaži entitetove prikvačene veze ispod unosa.',
            ],
            'show_attributes'   => 'Prikaži prikvačene atribute',
            'show_members'      => 'Prikaži članove',
            'show_relations'    => 'Pokaži prikvačene odnose',
            'singular'          => 'Jedan',
            'tags'              => 'Filtrirajte popis nedavno izmijenjenih entiteta po navedenim oznakama.',
            'title'             => 'Nedavno izmijenjeno',
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
