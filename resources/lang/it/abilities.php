<?php

return [
    'abilities'     => [
        'title' => 'Abilità figlie di :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Aggiungi abilità all\'entità',
        ],
        'create'        => [
            'success'   => 'Aggiunta abilità :name all\'entità',
            'title'     => 'Aggiungi un\'entità a :name',
        ],
        'description'   => 'Entità che hanno l\'abilità',
        'title'         => 'Abilità :name Entità',
    ],
    'create'        => [
        'success'   => 'Abilità \':name\' creata.',
        'title'     => 'Nuova Abilità',
    ],
    'destroy'       => [
        'success'   => 'Abilità \':name\' rimossa.',
    ],
    'edit'          => [
        'success'   => 'Abilità \':name\' aggiornata.',
        'title'     => 'Modifica Abilità :name',
    ],
    'entities'      => [
        'title' => 'Entità con l\'abilità :name',
    ],
    'fields'        => [
        'abilities' => 'Abilità',
        'ability'   => 'Abilità Genitore',
        'charges'   => 'Cariche',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Questa lista contiene tutte le abilità che sono discendenti di questa abilità e non solamente quelle direttamente sotto di essa.',
        'nested_parent' => 'Visualizzazione delle abilità di :parent',
        'nested_without'=> 'Visualizzazione di tutte le abilità che non hanno un\'abilità genitore. Clicca su una riga per vedere le abilità figlie.',
    ],
    'index'         => [
        'title' => 'Abilità',
    ],
    'placeholders'  => [
        'charges'   => 'Quantità di cariche. Fai riferimento agli attributi con {Level}*{CHA}',
        'name'      => 'Palla di Fuoco, Allerta, Colpo Scaltro',
        'type'      => 'Incantesimo, Talento, Attacco',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Abilità',
            'entities'  => 'Entità',
        ],
    ],
];
