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
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'Nouvel Objet',
        'description'   => 'Gestion des objets de :name.',
        'header'        => 'Objets de :name',
        'title'         => 'Objets',
    ],
    'placeholders'  => [
        'character' => 'Choix dun personnage',
        'location'  => 'Choix d\'un lieu',
        'name'      => 'Nom de l\'objet',
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
            'quests'        => 'Quêtes',
        ],
        'title'         => 'Objet :name',
    ],
];
