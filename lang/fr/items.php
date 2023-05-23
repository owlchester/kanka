<?php

return [
    'create'        => [
        'title' => 'Ajouter un objet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personnage',
        'price'     => 'Prix',
        'size'      => 'Taille',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage de tous les objets qui n\'ont pas de parent. Cliques sur une rangée pour voir les enfants.',
    ],
    'hints'         => [
        'items' => 'Organises les objets en utilisant le champ objet parent.',
    ],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
        'price' => 'Prix de l\'objet',
        'size'  => 'Taille, poids, dimensions.',
        'type'  => 'Arme, Potion, Coffre',
    ],
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventaires',
        ],
    ],
];
