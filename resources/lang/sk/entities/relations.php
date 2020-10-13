<?php

return [
    'create'        => [
        'success'   => 'Vzťah pre :name pridaný.',
        'title'     => 'Vytvoriť vzťah',
    ],
    'destroy'       => [
        'success'   => 'Vzťah pre :name odstránený',
    ],
    'fields'        => [
        'attitude'  => 'Postoj',
        'is_star'   => 'Pripnutý',
        'relation'  => 'Vzťah',
        'target'    => 'Cieľ',
        'two_way'   => 'Vytvoriť zrkadlenie vzťahu',
    ],
    'helper'        => 'Vytvor vzťahy medzi objektami s postojom a viditeľnosťou. Vzťahy môžu byť tiež pripnuté k menu objektu.',
    'hints'         => [
        'attitude'  => 'Toto nepovinné pole môže usporiadať poradie vzťahov štandardne podľa hodnoty vzťahu.',
        'mirrored'  => [
            'text'  => 'Tento vzťah je zrkadlený s :link.',
            'title' => 'Zrkadlený',
        ],
        'two_way'   => 'Keď vytvoríš zrkadlenie vzťahu, vytvorí sa rovnaký vzťah aj u cieľového objektu. Ak bude neskôr upravovaný, zrkadlený vzťah nebude zmenami dotknutý.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 až 100, kde 100 je max. pozitívny',
        'relation'  => 'Typ vzťahu',
        'target'    => 'Vybrať objekt',
    ],
    'show'          => [
        'title' => 'Vzťahy pre :name',
    ],
    'teaser'        => 'Boostni kampaň pre prístup k správcovi vzťahov. Viac informácií o boostnutých kampaniach získaš kliknutím sem.',
    'types'         => [
        'family_member'         => 'Člen rodu',
        'organisation_member'   => 'Člen organizácie',
    ],
    'update'        => [
        'success'   => 'Vzťah pre :name bol upravený',
        'title'     => 'Upraviť vzťahy',
    ],
];
