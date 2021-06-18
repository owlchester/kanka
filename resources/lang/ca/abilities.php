<?php

return [
    'abilities'     => [
        'title' => 'Habilitats descendents de :name',
    ],
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
        'success'   => 'S\'ha creat l\'habilitat «:name».',
        'title'     => 'Nova habilitat',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'habilitat «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'habilitat «:name».',
        'title'     => 'Edita l\'habilitat :name',
    ],
    'entities'      => [
        'title' => 'Entitats amb l\'habilitat :name',
    ],
    'fields'        => [
        'abilities' => 'Habilitats',
        'ability'   => 'Habilitat superior',
        'charges'   => 'Usos',
        'name'      => 'Nom',
        'type'      => 'Tipus',
    ],
    'helpers'       => [
        'descendants'   => 'Aquí es mostren totes les habilitats descendents d\'aquesta, no només les que es troben al nivell immediatament inferior.',
        'nested_parent' => 'S\'estan mostrant les habilitats de :parent.',
        'nested_without'=> 'S\'estan mostrant totes les habilitats que no tenen cap pare. Cliqueu una fila per a veure\'n les habilitats descendents.',
    ],
    'index'         => [
        'add'           => 'Nova habilitat',
        'description'   => 'Poders, encanteris, millores i més per a les entitats.',
        'header'        => 'Habilitats de :name',
        'title'         => 'Habilitats',
    ],
    'placeholders'  => [
        'charges'   => 'Quantitat d\'usos. Es pot referenciar un atribut amb {Nivell}*{CHA}',
        'name'      => 'Bola de foc, Alerta, Punyalada trapera...',
        'type'      => 'Encanteri, Proesa, Atac...',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Habilitats',
            'entities'  => 'Entitats',
        ],
        'title' => 'Habilitat :name',
    ],
];
