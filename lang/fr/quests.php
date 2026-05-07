<?php

return [
    'create'        => [
        'title' => 'Ajouter une quête',
    ],
    'elements'      => [
        'create'        => [
            'success'   => 'L\'entrée :entity ajoutée à la quête.',
            'title'     => 'Nouvel élément pour :name',
        ],
        'destroy'       => [
            'success'   => 'L\'élément de quête :entity retiré.',
        ],
        'edit'          => [
            'success'   => 'L\'élément de quête :entity modifié.',
            'title'     => 'Modifier l\'élément de quête pour :name',
        ],
        'fields'        => [
            'copy_entity_entry' => 'Utiliser la description de l\'entrée',
            'entity_or_name'    => 'Sélection soit d\'une entrée de la campagne, soit d\'un nom pour cet élément.',
        ],
        'helpers'       => [
            'copy_entity_entry' => 'Affiche la description de l\'entrée liée à la place de la description personnalisée.',
        ],
        'placeholders'  => [
            'name'  => 'Nom de l\'élément',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Copier les éléments de la quête',
        'date'          => 'Date',
        'element_role'  => 'Rôle',
        'instigator'    => 'Instigateur',
        'is_completed'  => 'Completée',
        'location'      => 'Lieu de départ',
        'role'          => 'Rôle',
        'status'        => 'Statut',
    ],
    'helpers'       => [
        'is_completed'  => 'Sélectionner si la quête est considérée comme completée.',
        'status'        => 'Le statut actuel de la quête.',
    ],
    'hints'         => [
        'is_abandoned'  => 'Cette quête a été abandonnée.',
        'is_completed'  => 'Cette quête est terminée.',
        'is_ongoing'    => 'Cette quête est en cours.',
    ],
    'lists'         => [
        'empty' => 'Créé des quêtes pour enregistrer les objectifs, les scénarios ou les motivations des personnages.',
    ],
    'placeholders'  => [
        'date'      => 'Date réelle de la quête',
        'entity'    => 'Nom d\'un élément dans la quête',
        'location'  => 'Le lieu de départ de la quête',
        'role'      => 'Le rôle de l\'entrée dans la quête.',
        'type'      => 'Principale, side quest, personnage',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Ajouter un élément',
        ],
        'tabs'      => [
            'elements'  => 'Éléments',
        ],
    ],
    'status'        => [
        'abandoned'     => 'Abandonnée',
        'completed'     => 'Terminée',
        'not_started'   => 'Non commencée',
        'ongoing'       => 'En cours',
    ],
];
