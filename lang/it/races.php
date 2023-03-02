<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Visualizzazione di tutti i personaggi legati a questa razza e alle sue sotto-razze.',
            'characters'        => 'Visualizzazione di tutti i personaggi legati direttamente a questa razza.',
        ],
        'title'     => 'Personaggi appartenenti alla Razza \':name\'',
    ],
    'create'        => [
        'title' => 'Nuova Razza',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Personaggi',
        'locations'     => 'Luoghi',
        'race'          => 'Razza Genitore',
        'races'         => 'Sotto-Razze',
    ],
    'helpers'       => [
        'nested_without'    => 'Visualizzazione di tutte le razze che non hanno una razza genitore. Fai clic su una riga per vedere le razze figlie.',
    ],
    'index'         => [],
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
