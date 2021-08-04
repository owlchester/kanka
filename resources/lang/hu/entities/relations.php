<?php

return [
    'actions'       => [
        'mode-map'      => 'Viszonyok felfedező eszköze',
        'mode-table'    => 'Viszonyok és kapcsolatok táblázata',
    ],
    'connections'   => [
        'map_point'         => 'Térképpont',
        'mention'           => 'Említés',
        'quest_element'     => 'Küldetéselem',
        'timeline_element'  => 'Idővonalelem',
    ],
    'create'        => [
        'success'   => ':name új viszonyát létrehoztuk.',
        'title'     => 'Új viszony létrehozása számára: :name',
    ],
    'destroy'       => [
        'success'   => ':name viszonyát eltávolítottuk.',
    ],
    'fields'        => [
        'attitude'          => 'Hozzáállás',
        'connection'        => 'Kapcsolat',
        'is_star'           => 'Rögzítve',
        'relation'          => 'Viszony',
        'target'            => 'Célpont',
        'target_relation'   => 'Célpont viszony',
        'two_way'           => 'Tükörviszony létrehozása',
    ],
    'helper'        => 'Állíts be viszonyokat az entitások között a hozzáállás mértékével és a kapcsolat láthatóságát is beállítva. A viszonyok ki is tűzhetők az entitás menüjére.',
    'hints'         => [
        'attitude'          => 'Ez az opcionális mező arra használható, hogy kiválaszd, hogy mely jellemző alapján legyenek csökkenő sorrendben rendezve a viszonyok.',
        'mirrored'          => [
            'text'  => 'Tükörviszonyban van ezzel :link.',
            'title' => 'Tükörviszonyban',
        ],
        'target_relation'   => 'A viszony leírása a célpont szemszögéből. Hagyd üresen ehhez a szöveghez.',
        'two_way'           => 'Ha kiválasztod a tükörviszony létrehozását, a célponton is létrejön ugyanez a viszony - azonban, ha az egyiket szerkeszted, a tükörképe nem fog frissülni.',
    ],
    'options'       => [
        'mentions'  => 'Viszonyok + kapcsolódó + említett',
        'related'   => 'Viszonyok + kapcsolódó',
        'relations' => 'Viszonyok',
        'show'      => 'Mutasd',
    ],
    'panels'        => [
        'related'   => 'Kapcsolódó',
    ],
    'placeholders'  => [
        'attitude'  => '-100 és 100 közé eső érték, ahol 100 nagyon pozitív viszonyt mutat.',
        'relation'  => 'Rivális, legjobb barát, testvér',
        'target'    => 'Válassz ki egy entitást!',
    ],
    'show'          => [
        'title' => ':name viszonyai',
    ],
    'teaser'        => 'Erősítsd meg a kampányodat, hogy hozzáférj a viszonyfelfedezőhöz. Klikkelj, hogy többet megtudj a megerősített kampányokról.',
    'types'         => [
        'family_member'         => 'Családtag',
        'organisation_member'   => 'Szervezeti tag',
    ],
    'update'        => [
        'success'   => ':name viszonyát frissítettük.',
        'title'     => 'Viszonyok módosítása',
    ],
];
