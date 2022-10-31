<?php

return [
    'actions'       => [
        'add_element'   => 'Ajouter un élément à l\'ère :era',
        'back'          => 'Retour à :name',
        'edit'          => 'Modifier la chronologie',
        'save_order'    => 'Enregistrer les changements',
    ],
    'create'        => [
        'title' => 'Nouvelle chronologie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Copier les éléments',
        'copy_eras'     => 'Copier les ères',
        'eras'          => 'Ères',
        'reverse_order' => 'Inverser l\'ordre des ères',
        'timeline'      => 'Chronologie parent',
        'timelines'     => 'Chronologies',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage des chronologies sans parent. Cliquer sur une rangée pour afficher les chronologies enfants.',
        'no_era'            => 'Cette chronologie ne possède pas d\'ères. Les ères peuvent être ajoutées dans l\'interface d\'édition de la chronologie, après quoi des éléments pourront être ajouté ici.',
        'reverse_order'     => 'Activer pour afficher les ères dans le sens chronologique inversé (plus ancien en premier)',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nom de la chronologie',
        'type'  => 'Principale, chronique du monde, chronologie du royaume',
    ],
    'reorder'       => [
        'success'   => 'Chronologie réordonnée.',
        'title'     => 'Réordonner la chronologie',
    ],
    'show'          => [
        'tabs'  => [
            'reorder'   => 'Réordonner',
            'timelines' => 'Chronologies',
        ],
    ],
    'timelines'     => [
        'title' => 'Chronologies de la chronologie :name',
    ],
];
