<?php

return [
    'create'        => [
        'title' => 'Nova família',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Membres',
    ],
    'helpers'       => [
        'descendants'       => 'Aquí es mostren totes les famílies que són descendents d\'aquesta família, no només les immediatament inferiors.',
        'nested_without'    => 'S\'estan mostrant les famílies sense pare per defecte. Feu clic a la fila d\'una família per a mostrar-ne els descendents.',
    ],
    'hints'         => [
        'members'   => 'Aquí es mostren els membres d\'una família. Es pot afegir un personatge a una família des del menú d\'edició d\'aquest, mitjançant el desplegable «Família».',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Aquí es mostren tots els personatges d\'aquesta família i de totes les subfamílies.',
            'direct_members'    => 'Totes les famílies felices s\'assemblen; cada família infeliç ho és a la seva manera. Aquí es mostren els personatges que són membres directes d\'aquesta família.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nom de la família',
        'type'  => 'Real, noble, extingida...',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Membres',
        ],
    ],
];
