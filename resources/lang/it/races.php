<?php

return [
    'characters'    => [
        'description'   => 'Personaggi appartenenti alla razza.',
        'title'         => 'Personaggi appartenenti alla Razza \':name\'',
    ],
    'create'        => [
        'description'   => 'Crea una nuova razza',
        'success'       => 'Razza \':name\' creata.',
        'title'         => 'Nuova Razza',
    ],
    'destroy'       => [
        'success'   => 'Razza \':name\' rimossa.',
    ],
    'edit'          => [
        'success'   => 'Razza \':name\' aggiornata.',
        'title'     => 'Modifica la Razza \':name\'',
    ],
    'fields'        => [
        'characters'    => 'Personaggi',
        'name'          => 'Nome',
        'race'          => 'Razza Genitore',
        'races'         => 'Sotto-Razze',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Quando ci si trova nella vista annidata puoi vedere le tue Razze in maniera annidata. Razze senza genitori saranno mostrate in maniera predefinita. Razze con discendenti potranno essere premute per vederne i figli. Potrai continuare ad espandere le razze fino a quando non ci saranno più figli da mostrare.',
    ],
    'index'         => [
        'add'           => 'Nuova Razza',
        'description'   => 'Gestisci la razza per :name.',
        'header'        => 'Razze per :name',
        'title'         => 'Razze',
    ],
    'placeholders'  => [
        'name'  => 'Nome della razza',
        'type'  => 'Umano, Fata, Borg',
    ],
    'races'         => [
        'description'   => 'Razze appartenenti alla razza.',
        'title'         => 'Sottorazze per la Razza :name',
    ],
    'show'          => [
        'description'   => 'Una visualizzazione dettagliata di una razza',
        'tabs'          => [
            'characters'    => 'Personaggi',
            'menu'          => 'Menù',
            'races'         => 'Sottorazze',
        ],
        'title'         => 'Razza :name',
    ],
];
