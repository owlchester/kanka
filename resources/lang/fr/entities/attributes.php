<?php

return [
    'actions'       => [
        'apply_template'    => 'Appliquer un modèle d\'attribut',
        'manage'            => 'Gérer',
        'more'              => 'Plus d\'options',
        'remove_all'        => 'Tout supprimer',
    ],
    'errors'        => [
        'loop'      => 'Il y a une boucle sur la calculation de cet attribut!',
        'too_many'  => 'Il y a trop de temps sur cette entité, il n\'est pas possible d\'ajouter plus d\'attributs. Prière de supprimer des attributs avant de pouvoir en ajouter d\'autre.',
    ],
    'fields'        => [
        'attribute'             => 'Attribut',
        'community_templates'   => 'Modèles Communautaires',
        'is_private'            => 'Attributs privés',
        'is_star'               => 'Épinglé',
        'template'              => 'Modèle',
        'value'                 => 'Valeur',
    ],
    'filters'       => [
        'name'  => 'Nom d\'attribut',
        'value' => 'Valeur d\'attribut',
    ],
    'helpers'       => [
        'delete_all'    => 'Es-tu certain de vouloir supprimer tous les attributs de cette entité?',
        'setup'         => 'Tu peux représenter des valeurs comme les points de vie ou l\'intelligence d\'une entité avec les attributs. Ajoutes des attributs manuellement en cliquant le bouton :manage, ou applique ceux d\'un modèle d\'attributs.',
    ],
    'hints'         => [
        'is_private2'   => 'Si sélectionné, seuls les membres du rôle :admin-role pourront voir les attributs de cette entité.',
    ],
    'index'         => [
        'success'   => 'Attributs modifiés pour :entity.',
        'title'     => 'Attributs pour :name',
    ],
    'live'          => [
        'success'   => 'Attribut :attribute modifié.',
        'title'     => 'Modification de :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Nombre de quêtes, niveau de difficulté, initiative, population',
        'block'     => 'Nom du bloc',
        'checkbox'  => 'Nom de la case à cocher',
        'icon'      => [
            'class' => 'Classes FontAwesome ou RPG Awesome: fas fa-users',
            'name'  => 'Nom de l\'icône',
        ],
        'number'    => 'Nom du chiffre',
        'random'    => [
            'name'  => 'Nom de l\'attribut',
            'value' => '1-100 ou une liste de valeurs séparées par une virgule',
        ],
        'section'   => 'Nom de la section',
        'template'  => 'Sélectionner un modèle',
        'value'     => 'Valeur de l\'attribut',
    ],
    'show'          => [
        'title' => 'Attributs de :name',
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
        'number'    => 'Nombre',
        'random'    => 'Aléatoire',
        'section'   => 'Section',
        'text'      => 'Texte multiligne',
    ],
    'update'        => [
        'success'   => 'Les attributs de :entity ont été modifiés.',
    ],
    'visibility'    => [
        'entry'     => 'Attribut affiché sur le menu d\'entité.',
        'private'   => 'Attribut seulement visible aux membres du rôle "Admin".',
        'public'    => 'Attribut visible par tous les membres.',
        'tab'       => 'Attribut visible sous l\'onglet Attributs.',
    ],
];
