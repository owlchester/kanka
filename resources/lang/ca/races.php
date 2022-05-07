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
        'success'   => 'S\'ha creat la raça «:name».',
        'title'     => 'Nova raça',
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
        'nested_parent' => 'S\'estan mostrant les races de :parent.',
        'nested_without'=> 'S\'estan mostrant les races sense pare. Feu clic a la fila d\'una raça per a mostrar-ne les descendents.',
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
