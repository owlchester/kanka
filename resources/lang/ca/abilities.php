<?php

return [
    'abilities'     => [
        'title' => 'Habilitats descendents de :name',
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
    'fields'        => [
        'abilities' => 'Habilitats',
        'ability'   => 'Habilitat superior',
        'charges'   => 'Usos',
        'name'      => 'Nom',
        'type'      => 'Tipus',
    ],
    'helpers'       => [
        'descendants'   => 'Aquí es mostren totes les habilitats descendents d\'aquesta, no només les que es troben al nivell immediatament inferior.',
        'nested'        => 'Amb la vista niada es mostren les habilitats de forma agrupada. Les habilitats sense cap superior es mostraran per defecte. A les que tinguin sub-habilitats s\'hi pot clicar per a mostrar els seus descendents. Es pot seguir clicant fins que no hi hagi més descendents a mostrar.',
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
        ],
        'title' => 'Habilitat :name',
    ],
];
