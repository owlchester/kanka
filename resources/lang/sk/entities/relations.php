<?php

return [
    'actions'       => [
        'mode-map'      => 'Nástroj zobrazenia vzťahov',
        'mode-table'    => 'Tabuľka vzťahov a prepojení',
    ],
    'bulk'          => [
        'delete'    => '{1} :count vzťah odstránený.|[2,4] :count vzťahy odstránené.|[5,*] :count vzťahov odstránených.',
        'success'   => [
            'editing'           => '{1} :count vzťah aktualizovaný.|[2,4] :count vzťahy aktualizované.|[5,*] :count vzťahov aktualizovaných.',
            'editing_partial'   => '{1} :count/:total vzťah aktualizovaný.|[2,4] :count/:total vzťahy aktualizované.|[5,*] :count/:total vzťahov aktualizovaných.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Bod na mape',
        'mention'           => 'Referencia',
        'quest_element'     => 'Prvok úlohy',
        'timeline_element'  => 'Prvok časovej osy',
    ],
    'create'        => [
        'new_title' => 'Nový vzťah',
        'success'   => 'Vzťah pre :name pridaný.',
        'title'     => 'Vytvoriť vzťah',
    ],
    'destroy'       => [
        'success'   => 'Vzťah pre :name odstránený',
    ],
    'fields'        => [
        'attitude'          => 'Postoj',
        'connection'        => 'Prepojenie',
        'is_star'           => 'Pripnutý',
        'owner'             => 'Zdroj',
        'relation'          => 'Vzťah',
        'target'            => 'Cieľ',
        'target_relation'   => 'Vzťah cieľa',
        'two_way'           => 'Vytvoriť zrkadlenie vzťahu',
    ],
    'helper'        => 'Vytvor vzťahy medzi objektami s postojom a viditeľnosťou. Vzťahy môžu byť tiež pripnuté k menu objektu.',
    'helpers'       => [
        'no_relations'  => 'Tento objekt nemá aktuálne žiadne vzťahy s inými objektami v kampani.',
        'popup'         => 'Objekty kampane môžu byť medzi sebou prepojené pomocou vzťahov. Tieto môžu obsahovať popis, hodnotenie postoja, viditeľnosť podľa toho, kto ho má vidieť, atď.',
    ],
    'hints'         => [
        'attitude'          => 'Toto nepovinné pole môže usporiadať poradie vzťahov štandardne podľa hodnoty vzťahu.',
        'mirrored'          => [
            'text'  => 'Tento vzťah je zrkadlený s :link.',
            'title' => 'Zrkadlený',
        ],
        'target_relation'   => 'Popis vzťahu u cieľa. Ponechaj prázdne, ak sa má použiť text tohto vzťahu.',
        'two_way'           => 'Keď vytvoríš zrkadlenie vzťahu, vytvorí sa rovnaký vzťah aj u cieľového objektu. Ak bude neskôr upravovaný, zrkadlený vzťah nebude zmenami dotknutý.',
    ],
    'index'         => [
        'title' => 'Vzťahy',
    ],
    'options'       => [
        'mentions'  => 'Vzťahy + Prepojené + Referencie',
        'related'   => 'Vzťahy + Prepojené',
        'relations' => 'Vzťahy',
        'show'      => 'Zobraziť',
    ],
    'panels'        => [
        'related'   => 'Prepojené',
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
