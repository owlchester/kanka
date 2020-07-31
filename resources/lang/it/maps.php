<?php

return [
    'actions'       => [
        'back'      => 'Torna a :name',
        'edit'      => 'Modifica mappa',
        'explore'   => 'Esplora',
    ],
    'create'        => [
        'success'   => 'Mappa :name creata.',
        'title'     => 'Nuova Mappa',
    ],
    'edit'          => [
        'success'   => 'Mappa :name aggiornata.',
        'title'     => 'Modifica Mappa :name',
    ],
    'fields'        => [
        'distance_measure'  => 'Valore di Distanza',
        'distance_name'     => 'Unità di Lunghezza',
        'grid'              => 'Griglia',
        'map'               => 'Mappa Genitore',
        'maps'              => 'Mappe',
        'name'              => 'Nome',
        'type'              => 'Tipo',
    ],
    'helpers'       => [
        'descendants'       => 'Questa lsita contiene tutte le mappe che sono discendenti di questa mappa, e non solo quelle direttamente sotto di essa.',
        'distance_measure'  => 'Fornire alla mappa una misurazione della distanza attiverà lo strumento di misurazione nella modalità Esplora.',
        'grid'              => 'Definisci la dimensione della griglia che sarà mostrata nella modalità Esplora.',
        'missing_image'     => 'Devi salvare la mappa fornendo un\'immagine prima di poter essere in grado di aggiungere livelli e marcatori.',
        'nested'            => 'Quando ti trovi nella vista annidata puoi vedere le tue mappe in maniera annidata. Mappe senza genitori saranno mostrate in maniera predefinita. Mappe con discendenti potranno essere premute per vederne i figli. Potrai continuare ad espandere le mappe fino a quando non ci saranno più figli da mostrare.',
    ],
    'index'         => [
        'add'   => 'Nuova Mappa',
        'title' => 'Mappe',
    ],
    'maps'          => [
        'title' => 'Mappe di :name',
    ],
    'panels'        => [
        'layers'    => 'Livelli',
        'markers'   => 'Marcatori',
        'settings'  => 'Opzioni',
    ],
    'placeholders'  => [
        'distance_measure'  => 'Unità per pixel',
        'distance_name'     => 'Nome dell\'unità di lunghezza (chilometro, miglio)',
        'grid'              => 'Distanza in pixel tra gli elementi della griglia. Lascia vuoto per nascondere la griglia.',
        'name'              => 'Nome della mappa',
        'type'              => 'Dungeon, Città, Galassia',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mappe',
        ],
        'title' => 'Mappa :name',
    ],
];
