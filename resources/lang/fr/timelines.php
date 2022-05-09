<?php

return [
    'actions'       => [
        'add_element'   => 'Ajouter un élément à l\'ère :era',
        'back'          => 'Retour à :name',
        'edit'          => 'Modifier la chronologie',
        'reorder'       => 'Réordonner',
        'save_order'    => 'Enregistrer les changements',
    ],
    'create'        => [
        'success'   => 'La chronologie :name a été créée.',
        'title'     => 'Nouvelle chronologie',
    ],
    'destroy'       => [
        'success'   => 'La chronologie :name a été supprimée.',
    ],
    'edit'          => [
        'success'   => 'La chronologie :name a été modifiée.',
        'title'     => 'Modifier la chronologie :name',
    ],
    'fields'        => [
        'copy_elements' => 'Copier les éléments',
        'copy_eras'     => 'Copier les ères',
        'eras'          => 'Ères',
        'name'          => 'Nom',
        'reverse_order' => 'Inverser l\'ordre des ères',
        'timeline'      => 'Chronologie parent',
        'timelines'     => 'Chronologies',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested_parent'     => 'Affichage des chronologies de :parent.',
        'nested_without'    => 'Affichage des chronologies sans parent. Cliquer sur une rangée pour afficher les chronologies enfants.',
        'no_era'            => 'Cette chronologie ne possède pas d\'ères. Les ères peuvent être ajoutées dans l\'interface d\'édition de la chronologie, après quoi des éléments pourront être ajouté ici.',
        'reorder'           => 'Glisser déposer les éléments de l\'ère pour les réorganiser.',
        'reorder_tooltip'   => 'Cliquer pour activer la réorganisation des éléments, puis les glisser-déposer pour les réordonner.',
        'reverse_order'     => 'Activer pour afficher les ères dans le sens chronologique inversé (plus ancien en premier)',
    ],
    'index'         => [
        'title' => 'Chronologies',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la chronologie',
        'type'  => 'Principale, chronique du monde, chronologie du royaume',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Chronologies',
        ],
    ],
    'timelines'     => [
        'title' => 'Chronologies de la chronologie :name',
    ],
];
