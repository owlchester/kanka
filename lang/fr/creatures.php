<?php

return [
    'create'        => [
        'title' => 'Nouvelle créature',
    ],
    'creatures'     => [
        'title' => 'Sous-créatures de :name',
    ],
    'fields'        => [
        'creature'  => 'Créature parent',
        'creatures' => 'Sous-créatures',
        'locations' => 'Lieux',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage de toutes les créatures qui n\'ont pas de créature parent. Clique sur une rangée pour voir les créatures enfants.',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la créature',
        'type'  => 'Herbivore, aquatique, mythique',
    ],
    'show'          => [
        'tabs'  => [
            'creatures' => 'Sous-créatures',
        ],
    ],
];
