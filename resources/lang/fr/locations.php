<?php

return [
    'attributes'    => [
        'actions'       => [
            'add'   => 'Ajouter un attribut',
        ],
        'create'        => [
            'description'   => 'Définir un attribut pour un lieu',
            'success'       => 'Attribut ajouté à :name.',
            'title'         => 'Nouvel attribut pour :name',
        ],
        'destroy'       => [
            'success'   => 'Attribut pour :name supprimé.',
        ],
        'edit'          => [
            'description'   => '',
            'success'       => 'Attribut pour :name modifié.',
            'title'         => 'Modifier un attribut pour :name',
        ],
        'fields'        => [
            'attribute' => 'Attribut',
            'value'     => 'Valeur',
        ],
        'placeholders'  => [
            'attribute' => 'Population, Nombre d\'inondations, Taille',
            'value'     => 'Valeur de l\'attribut',
        ],
    ],
    'create'        => [
        'description'   => '',
        'success'       => 'Lieu \':name\' créé.',
        'title'         => 'Ajouter un lieu',
    ],
    'destroy'       => [
        'success'   => 'Lieu \':name\' supprimé.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Lieu \':name\' modifié.',
        'title'         => 'Modifier Lieu :name',
    ],
    'fields'        => [
        'characters'    => 'Personnages',
        'description'   => 'Description',
        'history'       => 'Histoire',
        'image'         => 'Image',
        'location'      => 'Lieu',
        'name'          => 'Nom',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'index'         => [
        'add'           => 'New Lieu',
        'description'   => 'Gérer les lieux of :name.',
        'header'        => 'Lieux de :name',
        'title'         => 'Lieux',
    ],
    'placeholders'  => [
        'location'  => 'Choix d\'un lieu parent',
        'name'      => 'Nom du lieu',
        'type'      => 'Village, Royaume, Ruine',
    ],
    'show'          => [
        'description'   => 'Détail d\'un lieu',
        'tabs'          => [
            'attributes'    => 'Attributs',
            'characters'    => 'Personnages',
            'information'   => 'Information',
            'locations'     => 'Lieux',
            'relations'     => 'Relations',
        ],
        'title'         => 'Lieu :name',
    ],
];
