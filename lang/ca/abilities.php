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
    'helpers'       => [
        'nested_without'    => 'S\'estan mostrant totes les habilitats que no tenen cap pare. Cliqueu una fila per a veure\'n les habilitats descendents.',
    ],
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
