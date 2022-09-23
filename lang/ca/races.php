<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Mostrant tots els personatges relacionats amb aquesta raça i les seves descendents.',
            'characters'        => 'Mostrant tots els personatges directament relacionats amb aquesta raça.',
        ],
        'title'     => 'Personatges de la raça :name',
    ],
    'create'        => [
        'title' => 'Nova raça',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Personatges',
        'name'          => 'Nom',
        'race'          => 'Raça superior',
        'races'         => 'Sub-races',
        'type'          => 'Tipus',
    ],
    'helpers'       => [
        'nested_without'    => 'S\'estan mostrant les races sense pare. Feu clic a la fila d\'una raça per a mostrar-ne les descendents.',
    ],
    'index'         => [
        'title' => 'Races',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la raça',
        'type'  => 'Humà, elf, follet...',
    ],
    'races'         => [
        'title' => 'Sub-races de la raça :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Personatges',
            'races'         => 'Sub-races',
        ],
    ],
];
