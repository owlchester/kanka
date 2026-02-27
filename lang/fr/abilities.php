<?php

return [
    'children'      => [
        'actions'       => [
            'attach'    => 'Ajouter des entrées',
        ],
        'create'        => [
            'attach_success'    => '{1} Le pouvoir :name ajouté à :count entrée.|[2,*] Le pouvoir :name ajouté à :count entrées.',
            'helper'            => 'Attacher :name à une ou plusieurs entrées.',
            'title'             => 'Attacher des entrées',
        ],
        'description'   => 'Entrées ayant le pouvoir',
        'title'         => 'Entrées du pouvoir :name',
    ],
    'create'        => [
        'title' => 'Nouveau pouvoir',
    ],
    'fields'        => [
        'charges'   => 'Charges',
    ],
    'lists'         => [
        'empty' => 'Ajoute des pouvoirs, des sorts ou des talents. De nombreux créateurs utilisent cette fonctionnalité pour modéliser les classes de D&D.',
    ],
    'placeholders'  => [
        'charges'   => 'Nombre d\'utilisation. Les propriétés peuvent être référencées avec {Level}*{CHA}',
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
            'reorder'   => 'Réorganiser les pouvoirs',
        ],
    ],
];
