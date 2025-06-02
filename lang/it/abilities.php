<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'attach'    => 'Allega alle entità',
        ],
        'create'        => [
            'attach_success'    => '{1} Allega l\'abilità :name a :count entità.|[2,*] Allega l\'abilità :name a :count entità.',
        ],
        'description'   => 'Entità che hanno l\'abilità',
        'title'         => 'Abilità :name Entità',
    ],
    'create'        => [
        'title' => 'Nuova Abilità',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Cariche',
    ],
    'helpers'       => [],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Quantità di cariche. Fai riferimento agli attributi con {Level}*{CHA}',
        'name'      => 'Palla di Fuoco, Allerta, Colpo Scaltro',
        'type'      => 'Incantesimo, Talento, Attacco',
    ],
    'reorder'       => [
        'parentless'    => 'Nessuno Genitore',
        'success'       => 'Abilità riordinate con successo.',
        'title'         => 'Riordina le abilità',
    ],
    'show'          => [
        'tabs'  => [
            'entities'  => 'Entità',
            'reorder'   => 'Riordina le abilità',
        ],
    ],
];
