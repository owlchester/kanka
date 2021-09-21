<?php

return [
    'actions'       => [
        'mode-map'      => 'Průzkumník souvislostí',
        'mode-table'    => 'Tabulka souvislostí a vztahů',
    ],
    'connections'   => [
        'map_point'         => 'Bod na mapě',
        'mention'           => 'Odkaz',
        'quest_element'     => 'Prvek dobrodružství',
        'timeline_element'  => 'Prvek časové osy',
    ],
    'create'        => [
        'success'   => 'Vztah :target přidán k objektu.',
        'title'     => 'Nový vztah objektu :name',
    ],
    'destroy'       => [
        'success'   => 'Vztah :target odstraněn z objektu :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Postoj',
        'connection'        => 'Souvislost',
        'is_star'           => 'Připnuté',
        'relation'          => 'Vztah',
        'target'            => 'Cíl',
        'target_relation'   => 'Cílový vztah',
        'two_way'           => 'Vytvořit oboustranný vztah',
    ],
    'helper'        => 'Vytvořit vztahy mezi objekty včetně viditelnosti a vzájemných názorů. Vztahy lze připnout k nabídce objektu.',
    'hints'         => [
        'attitude'          => 'Toto volitelné pole lze použít pro výběr výchozího řazení vztahů.',
        'mirrored'          => [
            'text'  => 'Druhý objekt tohoto oboustranného vztahu najdete zde :link.',
            'title' => 'Oboustranný',
        ],
        'target_relation'   => 'Popis vztahu u objektu cíle. Pokud zůstane prázdné, použije se text tohoto vztahu.',
        'two_way'           => 'Pokud vytvoříš oboustranný vztah, vytvoří se shodný vztah i u cílového objektu. Pokud ale tento vztah upravíš, vztah u druhého objektu se automaticky nezaktualizuje.',
    ],
    'options'       => [
        'mentions'  => 'Vztahy + související + odkazy',
        'related'   => 'Vztahy + související',
        'relations' => 'Vztahy',
        'show'      => 'Zobrazit',
    ],
    'panels'        => [
        'related'   => 'Související',
    ],
    'placeholders'  => [
        'attitude'  => 'Rozsah -100 až 100, kde 100 je velmi kladné.',
        'relation'  => 'Protivník, nejlepší přítel, sourozenec...',
        'target'    => 'Vyber objekt',
    ],
    'show'          => [
        'title' => 'Vztahy objektu :name',
    ],
    'teaser'        => 'Zvýhodněním (boost) tažení získáte přístup k průzkumníku souvislostí. Další informace o zvýhodněných (boosted) taženích získáš klepnutím.',
    'types'         => [
        'family_member'         => 'Člen rodu',
        'organisation_member'   => 'Člen organizace',
    ],
    'update'        => [
        'success'   => 'Vztah objektu :target aktualizován pro :entity.',
        'title'     => 'Aktualizovat vztahy objektu :name',
    ],
];
