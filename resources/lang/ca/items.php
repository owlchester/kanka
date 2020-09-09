<?php

return [
    'create'        => [
        'description'   => 'Crear un objecte nou',
        'success'       => 'S\'ha creat l\'objecte «:name».',
        'title'         => 'Nou objecte',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'objecte «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'objecte «:name».',
        'title'     => 'Edita l\'objecte :name',
    ],
    'fields'        => [
        'character' => 'Personatge',
        'image'     => 'Imatge',
        'location'  => 'Lloc',
        'name'      => 'Nom',
        'price'     => 'Preu',
        'relation'  => 'Relació',
        'size'      => 'Tamany',
        'type'      => 'Tipus',
    ],
    'index'         => [
        'add'           => 'Nou objecte',
        'description'   => 'Gestiona els objectes de :name.',
        'header'        => 'Objectes de :name',
        'title'         => 'Objectes',
    ],
    'inventories'   => [
        'description'   => 'Els inventaris on es troba aquest objecte.',
        'title'         => 'Inventaris de l\'objecte :name',
    ],
    'placeholders'  => [
        'character' => 'Trieu un personatge',
        'location'  => 'Trieu un indret',
        'name'      => 'Nom de l\'objecte',
        'price'     => 'Preu de l\'objecte',
        'size'      => 'Grandària, pes, dimensions',
        'type'      => 'Arma, poció, artefacte...',
    ],
    'quests'        => [
        'description'   => 'Missions on apareix l\'objecte.',
        'title'         => 'Missions de :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada de l\'objecte',
        'tabs'          => [
            'information'   => 'Informació',
            'inventories'   => 'Inventaris',
            'quests'        => 'Missions',
        ],
        'title'         => 'Objecte :name',
    ],
];
