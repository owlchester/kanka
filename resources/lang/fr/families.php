<?php

return [
    'create'        => [
        'description'   => 'Créer une nouvelle famille',
        'success'       => 'Famille \':name\' ajoutée.',
        'title'         => 'Nouvelle Famille',
    ],
    'destroy'       => [
        'success'   => 'Famille \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Famille \':name\' modifiée.',
        'title'         => 'Modifier la famille :name',
    ],
    'fields'        => [
        'history'   => 'Histoire',
        'image'     => 'Image',
        'location'  => 'Lieu',
        'members'   => 'Members',
        'name'      => 'Nom',
        'relation'  => 'Relation',
    ],
    'hints'         => [
        'members'   => 'Les membres d\'une famille sont affichés ici. Un personnage peut être ajouté à une famille lors de l\'édition du personnage en utilisant le champ "Famille".',
    ],
    'index'         => [
        'add'           => 'Nouvelle Famille',
        'description'   => 'Gérer les familles de :name.',
        'header'        => 'Familles de :name',
        'title'         => 'Familles',
    ],
    'placeholders'  => [
        'location'  => 'Choix d\'un lieu',
        'name'      => 'Nom de la famille',
    ],
    'show'          => [
        'description'   => 'Détail d\'une famille',
        'tabs'          => [
            'history'   => 'Histoire',
            'member'    => 'Membres',
            'relation'  => 'Relations',
        ],
        'title'         => 'Famille :name',
    ],
];
