<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Lier une personne à la quête',
            'success'       => 'Personne ajoutée à :name.',
            'title'         => 'Nouvelle personne pour :name',
        ],
        'destroy'   => [
            'success'   => 'Personne pour :name supprimé.',
        ],
        'edit'      => [
            'description'   => 'Modifier la personne d\'une quête',
            'success'       => 'Personne pour :name modifié.',
            'title'         => 'Modifier une personne pour :name',
        ],
        'fields'    => [
            'character'     => 'Personne',
            'description'   => 'Description',
        ],
        'title'     => 'Personnes dans :name',
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
        'character'     => 'Auteur',
        'characters'    => 'Personnes',
        'description'   => 'Description',
        'image'         => 'Image',
        'is_completed'  => 'Completée',
        'items'         => 'Objets',
        'locations'     => 'Lieux',
        'name'          => 'Nom',
        'organisations' => 'Organisations',
        'quest'         => 'Quête Parentale',
        'quests'        => 'Sous-quêtes',
        'role'          => 'Rôle',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'Ce mode de navigation permet d\'afficher les quêtes de manière imbriquée. Les quêtes sans quête parent seront affichées par défaut. Les quêtes possédant des sous-quêtes peuvent être cliqués pour afficher ces enfants. Tu peux continuer à cliquer jusqu\'à ce qu\'il n\'y ait plus d\'enfants à voir.',
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
    'items'         => [
        'create'    => [
            'description'   => 'Ajouter un objet à la quête',
            'success'       => 'Objet ajouté à la quête :name.',
            'title'         => 'Nouvel objet pour :name',
        ],
        'destroy'   => [
            'success'   => 'Objet :name retiré de la quête.',
        ],
        'edit'      => [
            'description'   => 'Modifier un objet de quête',
            'success'       => 'Objet modifier pour la quête :name.',
            'title'         => 'Modifier l\'objet pour :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'item'          => 'Objet',
        ],
        'title'     => 'Objets dans :name',
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
        'title'     => 'Lieux dans :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Ajouter une organisation à la quête',
            'success'       => 'Organisation ajoutée à :name.',
            'title'         => 'Nouvelle organisation pour :name',
        ],
        'destroy'   => [
            'success'   => 'Organisation retirée pour la quête :name.',
        ],
        'edit'      => [
            'description'   => 'Modifier l\'organisation d\'une quête',
            'success'       => 'Organisation modifiée pour la quête :name.',
            'title'         => 'Modifier l\'organisation pour :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'organisation'  => 'Organisation',
        ],
        'title'     => 'Organisations dans :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la quête',
        'quest' => 'Quête Parentale',
        'role'  => 'Le rôle de l\'entité dans la quête.',
        'type'  => 'Principale, side quest, personne',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Ajouter une personne',
            'add_item'          => 'Ajouter un objet',
            'add_location'      => 'Ajouter un lieu',
            'add_organisation'  => 'Ajouter une organisation',
        ],
        'description'   => 'Détail de la quête',
        'tabs'          => [
            'characters'    => 'Personnes',
            'information'   => 'Information',
            'items'         => 'Objets',
            'locations'     => 'Lieux',
            'organisations' => 'Organisations',
            'quests'        => 'Quêtes',
        ],
        'title'         => 'Quête :name',
    ],
];
