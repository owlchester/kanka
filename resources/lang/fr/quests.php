<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Lier un personnage à la quête',
            'success'       => 'Personnage ajouté à :name.',
            'title'         => 'Nouveau personnage pour :name',
        ],
        'destroy'   => [
            'success'   => 'Personnage pour :name supprimé.',
        ],
        'edit'      => [
            'description'   => 'Modifier le personnage d\'une quête',
            'success'       => 'Personnage pour :name modifié.',
            'title'         => 'Modifier un personnage pour :name',
        ],
        'fields'    => [
            'character'     => 'Personnage',
            'description'   => 'Description',
        ],
    ],
    'create'        => [
        'description'   => 'Créer une nouvelle quête',
        'success'       => 'Quête \':name\' créée.',
        'title'         => 'Ajouter une quête',
    ],
    'destroy'       => [
        'success'   => 'Quête \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => 'Modifier une quête',
        'success'       => 'Quête \':name\' modifiée.',
        'title'         => 'Modifier Quête :name',
    ],
    'fields'        => [
        'character'     => 'Instigateur',
        'characters'    => 'Personnages',
        'description'   => 'Description',
        'image'         => 'Image',
        'is_completed'  => 'Completée',
        'locations'     => 'Lieux',
        'name'          => 'Nom',
        'quest'         => 'Quête Parentale',
        'type'          => 'Type',
    ],
    'hints'         => [
        'quests'    => 'Un réseau de quêtes liées peut être créé à l\'aide du champ Quête Parentale.',
    ],
    'index'         => [
        'add'           => 'Nouvelle Quête',
        'description'   => 'Gérer les quêtes de :name.',
        'header'        => 'Quêtes de :name',
        'title'         => 'Quêtes',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Lier un lieu à la quête',
            'success'       => 'Lieu ajouté à :name.',
            'title'         => 'Nouveau lieu pour :name',
        ],
        'destroy'   => [
            'success'   => 'Lieu pour :name supprimé.',
        ],
        'edit'      => [
            'description'   => 'Modifier un lieu d\'une quête',
            'success'       => 'Lieu pour :name modifié.',
            'title'         => 'Modifier lieu pour :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'location'      => 'Lieu',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nom de la quête',
        'quest' => 'Quête Parentale',
        'type'  => 'Principale, side quest, personnage',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Ajouter un personnage',
            'add_location'  => 'Ajouter un lieu',
        ],
        'description'   => 'Détail de la quête',
        'tabs'          => [
            'characters'    => 'Personnages',
            'information'   => 'Information',
            'locations'     => 'Lieux',
            'quests'        => 'Quêtes',
        ],
        'title'         => 'Quête :name',
    ],
];
