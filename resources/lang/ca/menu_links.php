<?php

return [
    'create'            => [
        'success'   => 'S\'ha creat l\'enllaç directe «:name».',
        'title'     => 'Nou enllaç directe',
    ],
    'destroy'           => [
        'success'   => 'S\'ha eliminat l\'enllaç directe «:name».',
    ],
    'edit'              => [
        'success'   => 'S\'ha actualitzat l\'enllaç directe «:name».',
        'title'     => 'Enllaç directe :name',
    ],
    'fields'            => [
        'dashboard'     => 'Taulell',
        'entity'        => 'Entitat',
        'filters'       => 'Filtres',
        'is_nested'     => 'Niuat',
        'menu'          => 'Menú',
        'name'          => 'Nom',
        'position'      => 'Posició',
        'random'        => 'Aleatori',
        'random_type'   => 'Tipus aleatori d\'entitat',
        'selector'      => 'Configuració dels enllaços directes',
        'tab'           => 'Pestanya',
        'type'          => 'Tipus d\'entitat',
    ],
    'helpers'           => [
        'dashboard' => 'Podeu vincular un enllaç directe amb un dels taulells personalitzats de la campanya.',
        'entity'    => 'Configureu aquest enllaç directe per a accedir directament a una entitat. El camp de :tab controla quina pestanya estarà seleccionada. El camp de :menu controla què subpàgina de l\'entitat s\'obrirà.',
        'position'  => 'Aquest camp controla en quina ordre ascendent apareixen els enllaços de l\'accés directe.',
        'random'    => 'Utilitzeu aquest camp per a fer un enllaç directe cap a una entitat aleatòria. Podeu filtrar l\'enllaç per anar només a un tipus específic d\'entitat.',
        'selector'  => 'Configureu on envia aquest enllaç quan un usuari el clica des de la barra lateral.',
        'type'      => 'Configureu aquest enllaç directe per a anar directament a una llista d\'entitats. Per a filtrar els resultats, copieu les parts de la URL de la llista filtrada a partir del símbol :? al camp de :filter.',
    ],
    'index'             => [
        'add'   => 'Nou enllaç directe',
        'title' => 'Accés directe',
    ],
    'placeholders'      => [
        'entity'    => 'Trieu una entitat',
        'filters'   => 'location_id=15&type=ciutat',
        'menu'      => 'Subpàgina del menú (usa l\'última part de la url)',
        'name'      => 'Nom de l\'enllaç directe',
        'tab'       => 'Presentació, relacions, notes...',
    ],
    'random_no_entity'  => 'No s\'ha trobat cap entitat aleatòria.',
    'random_types'      => [
        'any'   => 'Qualsevol entitat',
    ],
    'reorder'           => [
        'success'   => 'S\'han reordenat els accessos directes.',
        'title'     => 'Reordena els accessos directes',
    ],
    'show'              => [
        'title' => 'Enllaç directe :name',
    ],
];
