<?php

return [
    'actions'       => [
        'mode-map'      => 'Alat za istraživanje odnosa',
        'mode-table'    => 'Tablica odnosa i veza',
    ],
    'connections'   => [
        'map_point'         => 'Točka karte',
        'mention'           => 'Spomenuti',
        'quest_element'     => 'Element zadatka',
        'timeline_element'  => 'Element kronologije',
    ],
    'create'        => [],
    'destroy'       => [
        'success'   => 'Uklonjen odnos :target s :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Stav',
        'connection'        => 'Veza',
        'relation'          => 'Odnos',
        'target'            => 'Meta',
        'target_relation'   => 'Cilj odnosa',
        'two_way'           => 'Kreiraj zrcalni odnos',
    ],
    'helper'        => 'Uspostavite odnose između entiteta sa stavovima i vidljivošću. Odnosi se mogu prikvačiti i na izbornik entiteta.',
    'hints'         => [
        'attitude'          => 'Ovo opcionalno polje se može koristiti za postavljanje zadanog poretka odnosa na silazno po tom polju.',
        'mirrored'          => [
            'text'  => 'Ovaj odnos se zrcali s :link.',
            'title' => 'Zrcaljen',
        ],
        'target_relation'   => 'Opis odnosa na cilju. Ostavi prazno za korištenje teksta ovog odnosa.',
        'two_way'           => 'Ako odaberete kreiranje zrcalnog odnosa, isti odnos će se kreirati na meti. Međutim, ako ga uredite, zrcaljenje se neće ažurirati.',
    ],
    'options'       => [
        'mentions'  => 'Odnosi + srodno + spomeni',
        'related'   => 'Odnosi + srodno',
        'relations' => 'Odnosi',
        'show'      => 'Prikaži',
    ],
    'panels'        => [
        'related'   => 'Srodno',
    ],
    'placeholders'  => [
        'attitude'  => '-100 do 100, gdje je 100 vrlo pozitivno.',
        'relation'  => 'Vrsta odnosa',
        'target'    => 'Odaberi entitet',
    ],
    'show'          => [
        'title' => 'Odnosi za :name',
    ],
    'types'         => [
        'family_member'         => 'Član obitelji',
        'organisation_member'   => 'Član organizacije',
    ],
    'update'        => [
        'success'   => 'Ažuriran odnos :target za :entity.',
        'title'     => 'Ažuriraj odnose za :name',
    ],
];
