<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'add'   => 'Ajouter un pouvoir à une entité',
        ],
        'create'        => [
            'success'   => 'Le pouvoir :name a été ajouté à l\'entité.',
            'title'     => 'Ajouter une entité à :name',
        ],
        'description'   => 'Entités ayant le pouvoir',
        'title'         => 'Entités du pouvoir :name',
    ],
    'create'        => [
        'title' => 'Nouveau pouvoir',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Charges',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage des pouvoirs sans parent. Cliquer sur une rangée pour afficher les pouvoirs enfants.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Nombre d\'utilisation. Les attributs peuvent être référencés avec {Level}*{CHA}',
        'name'      => 'Jet de feu, Alert, Résistance',
        'type'      => 'Sort, Compétence, Attaque',
    ],
    'reorder'       => [
        'parentless'    => 'Aucun parent',
        'success'       => 'Pouvoirs réordonnés.',
        'title'         => 'Réorganiser les pouvoirs',
    ],
    'show'          => [
        'tabs'  => [
            'entities'  => 'Entités',
            'reorder'   => 'Réorganiser les pouvoirs',
        ],
    ],
];
