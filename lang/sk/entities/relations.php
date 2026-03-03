<?php

return [
    'actions'           => [
        'mode-map'      => 'Nástroj zobrazenia vzťahov',
        'mode-table'    => 'Tabuľka vzťahov a prepojení',
    ],
    'bulk'              => [
        'delete'    => '{1} :count vzťah odstránený.|[2,4] :count vzťahy odstránené.|[5,*] :count vzťahov odstránených.',
        'fields'    => [
            'delete_mirrored'   => 'Zmazať zrkadlené',
            'unmirror'          => 'Rozviazať zrkadlené',
            'update_mirrored'   => 'Aktualizovať zrkadlené',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Taktiež zmazať zrkadlené vzťahy.',
            'unmirror'          => 'Rozviazať zrkadlené vzťahy.',
            'update_mirrored'   => 'Aktualizovať zrkadlené vzťahy.',
        ],
        'success'   => [
            'editing'           => '{1} :count vzťah aktualizovaný.|[2,4] :count vzťahy aktualizované.|[5,*] :count vzťahov aktualizovaných.',
            'editing_partial'   => '{1} :count/:total vzťah aktualizovaný.|[2,4] :count/:total vzťahy aktualizované.|[5,*] :count/:total vzťahov aktualizovaných.',
        ],
    ],
    'call-to-action'    => 'Vizuálne objavuj vzťahy tohto objektu a ako je prepojený s ostatkom kampane.',
    'connections'       => [
        'map_point'         => 'Bod na mape',
        'mention'           => 'Referencia',
        'quest_element'     => 'Prvok úlohy',
        'timeline_element'  => 'Prvok časovej osy',
    ],
    'create'            => [
        'new_title'     => 'Nový vzťah',
        'success_bulk'  => '{1} Pridaný :count prepojenie k :entity.|[2,4] Pridané :count prepojenia k :entity.|[5,*] Pridaných :count prepojení k :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Tento vzťah sa zrkadlí na cieľovom objekte. Zvoľ túto možnosť, aby bol odstránený aj zrkadlený vzťah.',
        'option'    => 'Odstrániť zrkadlený vzťah',
    ],
    'destroy'           => [
        'mirrored'  => 'Toto tiež odstráni zrkadlené vzťahy a natrvalo.',
        'success'   => 'Vzťah pre :name odstránený',
    ],
    'fields'            => [
        'attitude'  => 'Postoj',
        'is_pinned' => 'Pripnuté',
        'owner'     => 'Zdroj',
        'target'    => 'Cieľ',
        'two_way'   => 'Vytvoriť zrkadlenie vzťahu',
        'unmirror'  => 'Zrušiť zrkadlenie tohto vzťahu.',
    ],
    'filters'           => [
        'connection'    => 'Vzťah prepojenia',
        'name'          => 'Cieľ prepojenia',
    ],
    'helper'            => 'Vytvor vzťahy medzi objektami s postojom a viditeľnosťou. Vzťahy môžu byť tiež pripnuté k menu objektu.',
    'helpers'           => [
        'no_relations'  => 'Tento objekt nemá aktuálne žiadne vzťahy s inými objektami v kampani.',
    ],
    'hints'             => [
        'attitude'  => 'Toto nepovinné pole môže usporiadať poradie vzťahov štandardne podľa hodnoty vzťahu.',
        'two_way'   => 'Keď vytvoríš zrkadlenie vzťahu, vytvorí sa rovnaký vzťah aj u cieľového objektu. Ak bude neskôr upravovaný, zrkadlený vzťah nebude zmenami dotknutý.',
    ],
    'index'             => [
        'title' => 'Vzťahy',
    ],
    'options'           => [
        'mentions'          => 'Vzťahy + Prepojené + Referencie',
        'only_relations'    => 'Iba priame vzťahy',
        'related'           => 'Vzťahy + Prepojené',
        'relations'         => 'Vzťahy',
        'show'              => 'Zobraziť',
    ],
    'panels'            => [
        'related'   => 'Prepojené',
    ],
    'placeholders'      => [
        'attitude'  => '-100 až 100, kde 100 je max. pozitívny',
    ],
    'show'              => [
        'title' => 'Vzťahy pre :name',
    ],
    'types'             => [
        'family_member'         => 'Člen rodu',
        'organisation_member'   => 'Člen organizácie',
    ],
    'update'            => [
        'success'   => 'Vzťah pre :name bol upravený',
        'title'     => 'Upraviť vzťahy',
    ],
];
