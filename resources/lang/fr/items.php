<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Objet \':name\' créé.',
        'title'         => 'Ajouter un objet',
    ],
    'destroy'       => [
        'success'   => 'Objet \':name\' supprimé.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Objet \':name\' modifié.',
        'title'         => 'Modifier Objet :name',
    ],
    'fields'        => [
        'character'     => 'Personnage',
        'description'   => 'Description',
        'history'       => 'Histoire',
        'image'         => 'Image',
        'location'      => 'Lieu',
        'name'          => 'Nom',
        'relation'      => 'Relation',
        'type'          => 'Type',
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
    'show'          => [
        'description'   => 'Détail d\'un objet',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Objet :name',
    ],
];
