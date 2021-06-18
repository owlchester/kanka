<?php

return [
    'actions'       => [
        'apply_template'    => 'Appliquer un modèle d\'attribut',
        'manage'            => 'Gérer',
        'more'              => 'Plus d\'options',
        'remove_all'        => 'Tout supprimer',
    ],
    'errors'        => [
        'loop'  => 'Il y a une boucle sur la calculation de cet attribut!',
    ],
    'fields'        => [
        'attribute'             => 'Attribut',
        'community_templates'   => 'Modèles Communautaires',
        'is_private'            => 'Attributs privés',
        'is_star'               => 'Épinglé',
        'template'              => 'Modèle',
        'value'                 => 'Valeur',
    ],
    'helpers'       => [
        'delete_all'    => 'Es-tu certain de vouloir supprimer tous les attributs de cette entité?',
    ],
    'hints'         => [
        'is_private'    => 'Tous les attributs d\'une entité peuvent être cachés des membres non-admin.',
    ],
    'index'         => [
        'success'   => 'Attributs modifiés pour :entity.',
        'title'     => 'Attributs pour :name',
    ],
    'placeholders'  => [
        'attribute' => 'Nombre de quêtes, niveau de difficulté, initiative, population',
        'block'     => 'Nom du bloc',
        'checkbox'  => 'Nom de la case à cocher',
        'icon'      => [
            'class' => 'Classes FontAwesome ou RPG Awesome: fas fa-users',
            'name'  => 'Nom de l\'icône',
        ],
        'random'    => [
            'name'  => 'Nom de l\'attribut',
            'value' => '1-100 ou une liste de valeurs séparées par une virgule',
        ],
        'section'   => 'Nom de la section',
        'template'  => 'Sélectionner un modèle',
        'value'     => 'Valeur de l\'attribut',
    ],
    'template'      => [
        'success'   => 'Modèle d\'attribut :name appliqué pour :entity.',
        'title'     => 'Appliquer un modèle d\'attribut pour :name',
    ],
    'types'         => [
        'attribute' => 'Attribut',
        'block'     => 'Bloc',
        'checkbox'  => 'Case à cocher',
        'icon'      => 'Icône',
        'random'    => 'Aléatoire',
        'section'   => 'Section',
        'text'      => 'Texte multiligne',
    ],
    'visibility'    => [
        'entry'     => 'Attribut affiché sur le menu d\'entité.',
        'private'   => 'Attribut seulement visible aux membres du rôle "Admin".',
        'public'    => 'Attribut visible par tous les membres.',
        'tab'       => 'Attribut visible sous l\'onglet Attributs.',
    ],
];
