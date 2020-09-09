<?php

return [
    'characters'    => [
        'description'   => 'Personatges d\'aquesta raça.',
        'title'         => 'Personatges de la raça :name',
    ],
    'create'        => [
        'description'   => 'Crea una nova raça',
        'success'       => 'S\'ha creat la raça «:name».',
        'title'         => 'Nova raça',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la raça «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat la raça «:name».',
        'title'     => 'Edita la raça :name',
    ],
    'fields'        => [
        'characters'    => 'Personatges',
        'name'          => 'Nom',
        'race'          => 'Raça superior',
        'races'         => 'Sub-races',
        'type'          => 'Tipus',
    ],
    'helpers'       => [
        'nested'    => 'Amb la vista niada, les races es mostren de forma agrupada. Les races que no tinguin raça superior es mostraran per defecte. A les races amb sub-races se\'ls pot clicar per a mostrar els seus descendents. Es pot seguir clicant fins que no hi hagi més descendents a mostrar.',
    ],
    'index'         => [
        'add'           => 'Nova raça',
        'description'   => 'Gestiona les races de :name.',
        'header'        => 'Races de :name',
        'title'         => 'Races',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la raça',
        'type'  => 'Humà, elf, follet...',
    ],
    'races'         => [
        'description'   => 'Races pertanyents a aquesta raça.',
        'title'         => 'Sub-races de la raça :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la raça',
        'tabs'          => [
            'characters'    => 'Personatges',
            'menu'          => 'Menú',
            'races'         => 'Sub-races',
        ],
        'title'         => 'Raça :name',
    ],
];
