<?php

return [
    'children'      => [
        'actions'       => [
            'attach'    => 'Ajouter des entités',
        ],
        'create'        => [
            'attach_success'    => '{1} Le pouvoir :name ajouté à :count entité.|[2,*] Le pouvoir :name ajouté à :count entités.',
            'helper'            => 'Attacher :name à une ou plusieurs entités.',
            'title'             => 'Attacher des entités',
        ],
        'description'   => 'Entités ayant le pouvoir',
        'title'         => 'Entités du pouvoir :name',
    ],
    'create'        => [
        'title' => 'Nouveau pouvoir',
    ],
    'fields'        => [
        'charges'   => 'Charges',
    ],
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
