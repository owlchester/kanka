<?php

return [
    'abilities'     => [],
    'children'      => [
        'description'   => 'Entitats que tenen l\'habilitat',
        'title'         => 'Entitats de l\'habilitat :name',
    ],
    'create'        => [
        'title' => 'Nova habilitat',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Usos',
    ],
    'helpers'       => [],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Quantitat d\'usos. Es pot referenciar un atribut amb {Nivell}*{CHA}',
        'name'      => 'Bola de foc, Alerta, Punyalada trapera...',
        'type'      => 'Encanteri, Proesa, Atac...',
    ],
    'show'          => [
        'tabs'  => [
            'entities'  => 'Entitats',
        ],
    ],
];
