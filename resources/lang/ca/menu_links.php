<?php

return [
    'create'        => [
        'success'   => 'S\'ha creat l\'enllaç directe «:name».',
        'title'     => 'Nou enllaç directe',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'enllaç directe «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'enllaç directe «:name».',
        'title'     => 'Enllaç directe :name',
    ],
    'fields'        => [
        'entity'    => 'Entitat',
        'filters'   => 'Filtres',
        'menu'      => 'Menú',
        'name'      => 'Nom',
        'position'  => 'Posició',
        'tab'       => 'Pestanya',
        'type'      => 'Tipus d\'entitat',
    ],
    'helpers'       => [
        'entity'    => 'Configureu aquest enllaç directe per a accedir directament a una entitat. El camp de :tab controla quina pestanya estarà seleccionada. El camp de :menu controla què subpàgina de l\'entitat s\'obrirà.',
        'position'  => 'Aquest camp controla en quina ordre ascendent apareixen els enllaços de l\'accés directe.',
        'type'      => 'Configureu aquest enllaç directe per a anar directament a una llista d\'entitats. Per a filtrar els resultats, copieu les parts de la URL de la llista filtrada a partir del símbol :? al camp de :filter.',
    ],
    'index'         => [
        'add'   => 'Nou enllaç directe',
        'title' => 'Accés directe',
    ],
    'placeholders'  => [
        'entity'    => 'Trieu una entitat',
        'filters'   => 'location_id=15&type=ciutat',
        'menu'      => 'Subpàgina del menú (usa l\'última part de la url)',
        'name'      => 'Nom de l\'enllaç directe',
        'tab'       => 'Presentació, relacions, notes...',
    ],
    'show'          => [
        'tabs'  => [
            'information'   => 'Informació',
        ],
        'title' => 'Enllaç directe :name',
    ],
];
