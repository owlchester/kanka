<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'add'   => 'Afegeix una habilitat a l\'entitat',
        ],
        'create'        => [
            'success'   => 'S\'ha afegit l\'habilitat :name a l\'entitat.',
            'title'     => 'Afegeix una entitat a :name',
        ],
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
