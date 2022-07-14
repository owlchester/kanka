<?php

return [
    'create'        => [
        'title' => 'Ajouter un objet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personnage',
        'image'     => 'Image',
        'item'      => 'Objet parent',
        'items'     => 'Sous-objets',
        'location'  => 'Lieu',
        'name'      => 'Nom',
        'price'     => 'Prix',
        'size'      => 'Taille',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage de tous les objets qui n\'ont pas de parent. Cliques sur une rangée pour voir les enfants.',
    ],
    'hints'         => [
        'items' => 'Organises les objets en utilisant le champ objet parent.',
    ],
    'index'         => [
        'title' => 'Objets',
    ],
    'inventories'   => [
        'title' => 'Inventaires de l\'objet :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de l\'objet',
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
