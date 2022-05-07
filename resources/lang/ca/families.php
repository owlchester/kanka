<?php

return [
    'create'        => [
        'success'   => 'S\'ha creat la família «:name».',
        'title'     => 'Nova família',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la família «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat la família «:name».',
        'title'     => 'Edita la família :name',
    ],
    'families'      => [
        'title' => 'Famílies de la família :name',
    ],
    'fields'        => [
        'families'  => 'Subfamílies',
        'family'    => 'Família antecessora',
        'image'     => 'Imatge',
        'location'  => 'Procedència',
        'members'   => 'Membres',
        'name'      => 'Nom',
        'type'      => 'Tipus',
    ],
    'helpers'       => [
        'descendants'   => 'Aquí es mostren totes les famílies que són descendents d\'aquesta família, no només les immediatament inferiors.',
        'nested_parent' => 'S\'estan mostrant les famílies de :parent.',
        'nested_without'=> 'S\'estan mostrant les famílies sense pare per defecte. Feu clic a la fila d\'una família per a mostrar-ne els descendents.',
    ],
    'hints'         => [
        'members'   => 'Aquí es mostren els membres d\'una família. Es pot afegir un personatge a una família des del menú d\'edició d\'aquest, mitjançant el desplegable «Família».',
    ],
    'index'         => [
        'title' => 'Famílies',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Aquí es mostren tots els personatges d\'aquesta família i de totes les subfamílies.',
            'direct_members'    => 'Totes les famílies felices s\'assemblen; cada família infeliç ho és a la seva manera. Aquí es mostren els personatges que són membres directes d\'aquesta família.',
        ],
        'title'     => 'Membres de la família :name',
    ],
    'placeholders'  => [
        'location'  => 'Trieu un indret',
        'name'      => 'Nom de la família',
        'type'      => 'Real, noble, extingida...',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Tots els membres',
            'families'      => 'Famílies',
            'members'       => 'Membres',
        ],
    ],
];
