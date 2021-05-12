<?php

return [
    'characters'    => [],
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
    'elements'      => [
        'create'    => [
            'success'   => 'L\'entité :entity ajoutée à la quête.',
            'title'     => 'Nouvel élément pour :name',
        ],
        'destroy'   => [
            'success'   => 'L\'élément de quête :entity retiré.',
        ],
        'edit'      => [
            'success'   => 'L\'élément de quête :entity modifié.',
            'title'     => 'Modifier l\'élément de quête pour :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'quest'         => 'Quête',
        ],
        'title'     => 'Éléments de quêtes pour :name',
    ],
    'fields'        => [
        'character'     => 'Auteur',
        'copy_elements' => 'Copier les éléments de la quête',
        'date'          => 'Date',
        'description'   => 'Description',
        'image'         => 'Image',
        'is_completed'  => 'Completée',
        'name'          => 'Nom',
        'quest'         => 'Quête Parentale',
        'quests'        => 'Sous-quêtes',
        'role'          => 'Rôle',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested_parent' => 'Affichage des quêtes de :parent.',
        'nested_without'=> 'Affichage des quêtes sans parent. Cliquer sur une rangée pour afficher les quêtes enfants.',
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
    'placeholders'  => [
        'date'  => 'Date réelle de la quête',
        'name'  => 'Nom de la quête',
        'quest' => 'Quête Parentale',
        'role'  => 'Le rôle de l\'entité dans la quête.',
        'type'  => 'Principale, side quest, personnage',
    ],
    'show'          => [
        'actions'       => [
            'add_element'   => 'Ajouter un élément',
        ],
        'description'   => 'Détail de la quête',
        'tabs'          => [
            'elements'      => 'Éléments',
            'information'   => 'Information',
            'quests'        => 'Quêtes',
        ],
        'title'         => 'Quête :name',
    ],
];
