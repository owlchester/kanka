<?php

return [
    'abilities'     => [
        'title' => 'Pouvoirs enfants de :name',
    ],
    'create'        => [
        'success'   => 'Pouvoir \':name\' créé.',
        'title'     => 'Nouveau pouvoir',
    ],
    'destroy'       => [
        'success'   => 'Pouvoir \':name\' supprimé.',
    ],
    'edit'          => [
        'success'   => 'Pouvoir \':name\' modifié.',
        'title'     => 'Modifier le pouvoir :name',
    ],
    'entities'      => [
        'title' => 'Entités avec le pouvoir :name',
    ],
    'fields'        => [
        'abilities' => 'Pouvoirs',
        'ability'   => 'Pouvoir Parent',
        'charges'   => 'Charges',
        'name'      => 'Nom',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Cette liste contient tous les pouvoirs qui sont descendants de ce pouvoir, et pas seulement les descendants directs.',
        'nested_parent' => 'Affichage des pouvoirs de :parent.',
        'nested_without'=> 'Affichage des pouvoirs sans parent. Cliquer sur une rangée pour afficher les pouvoirs enfants.',
    ],
    'index'         => [
        'add'           => 'Nouveau pouvoir',
        'description'   => 'Créer des pouvoirs, effets, sorts, compétences pour les entités.',
        'header'        => 'Pouvoirs de :name',
        'title'         => 'Pouvoirs',
    ],
    'placeholders'  => [
        'charges'   => 'Nombre d\'utilisation. Les attributs peuvent être référencés avec {Level}*{CHA}',
        'name'      => 'Jet de feu, Alert, Résistance',
        'type'      => 'Sort, Compétence, Attaque',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Pouvoirs',
            'entities'  => 'Entités',
        ],
        'title' => 'Pouvoir :name',
    ],
];
