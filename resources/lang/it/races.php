<?php

return [
    'characters'    => [
        'title' => 'Personaggi appartenenti alla Razza \':name\'',
    ],
    'create'        => [
        'title' => 'Nuova Razza',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Personaggi',
        'name'          => 'Nome',
        'race'          => 'Razza Genitore',
        'races'         => 'Sotto-Razze',
        'type'          => 'Tipo',
    ],
    'helpers'       => [],
    'index'         => [
        'title' => 'Razze',
    ],
    'placeholders'  => [
        'name'  => 'Nome della razza',
        'type'  => 'Umano, Fata, Borg',
    ],
    'races'         => [
        'title' => 'Sottorazze per la Razza :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Personaggi',
            'races'         => 'Sottorazze',
        ],
    ],
];
