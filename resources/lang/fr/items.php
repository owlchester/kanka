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
        'location'  => 'Lieu',
        'name'      => 'Nom',
        'price'     => 'Prix',
        'size'      => 'Taille',
        'type'      => 'Type',
    ],
    'index'         => [
        'title' => 'Objets',
    ],
    'inventories'   => [
        'title' => 'Inventaires de l\'objet :name',
    ],
    'placeholders'  => [
        'character' => 'Choix dun personnage',
        'location'  => 'Choix d\'un lieu',
        'name'      => 'Nom de l\'objet',
        'price'     => 'Prix de l\'objet',
        'size'      => 'Taille, poids, dimensions.',
        'type'      => 'Arme, Potion, Coffre',
    ],
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventaires',
        ],
    ],
];
