<?php

return [
    'create'        => [
        'description'   => 'Créer un nouvel objet',
        'success'       => 'Objet \':name\' créé.',
        'title'         => 'Ajouter un objet',
    ],
    'destroy'       => [
        'success'   => 'Objet \':name\' supprimé.',
    ],
    'edit'          => [
        'success'   => 'Objet \':name\' modifié.',
        'title'     => 'Modifier Objet :name',
    ],
    'fields'        => [
        'character' => 'Personnage',
        'image'     => 'Image',
        'location'  => 'Lieu',
        'name'      => 'Nom',
        'price'     => 'Prix',
        'relation'  => 'Relation',
        'size'      => 'Taille',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'Nouvel Objet',
        'description'   => 'Gestion des objets de :name.',
        'header'        => 'Objets de :name',
        'title'         => 'Objets',
    ],
    'inventories'   => [
        'description'   => 'Inventaires dans lesquels cet objet est.',
        'title'         => 'Inventaires de l\'objet :name',
    ],
    'placeholders'  => [
        'character' => 'Choix dun personnage',
        'location'  => 'Choix d\'un lieu',
        'name'      => 'Nom de l\'objet',
        'price'     => 'Prix de l\'objet',
        'size'      => 'Taille, poids, dimensions.',
        'type'      => 'Arme, Potion, Coffre',
    ],
    'quests'        => [
        'description'   => 'Quêtes dont l\'objet fait partie.',
        'title'         => 'Quêtes de l\'objet :name',
    ],
    'show'          => [
        'description'   => 'Détail d\'un objet',
        'tabs'          => [
            'information'   => 'Information',
            'inventories'   => 'Inventaires',
            'quests'        => 'Quêtes',
        ],
        'title'         => 'Objet :name',
    ],
];
