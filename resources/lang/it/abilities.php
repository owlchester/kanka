<?php

return [
    'abilities'     => [
        'title' => 'Abilità figlie di :name',
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
    'fields'        => [
        'abilities' => 'Abilità',
        'ability'   => 'Abilità Genitore',
        'charges'   => 'Cariche',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Questa lista contiene tutte le abilità che sono discendenti di questa abilità e non solamente quelle direttamente sotto di essa.',
        'nested'        => 'Quando ti trovi nella vista annidata puoi vedere le tue abilità in maniera annidata. Abilità senza genitori saranno mostrate in maniera predefinita. Abilità con discendenti potranno essere premute per vederne i figli. Potrai continuare ad espandere le abilità fino a quando non ci saranno più figli da mostrare.',
    ],
    'index'         => [
        'add'           => 'Nuova Abilità',
        'description'   => 'Crea Poteri, Incantesimi, Talenti e altro per le tue entità.',
        'header'        => 'Abilità di :name',
        'title'         => 'Abilità',
    ],
    'placeholders'  => [
        'charges'   => 'Quantità di cariche. Fai riferimento agli attributi con {Level}*{CHA}',
        'name'      => 'Palla di Fuoco, Allerta, Colpo Scaltro',
        'type'      => 'Incantesimo, Talento, Attacco',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Abilità',
        ],
        'title' => 'Abilità :name',
    ],
];
