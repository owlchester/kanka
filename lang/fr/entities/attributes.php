<?php

return [
    'actions'       => [
        'apply_template'    => 'Appliquer un modèle d\'attribut',
        'load'              => 'Charger',
        'manage'            => 'Gérer',
        'more'              => 'Plus d\'options',
        'remove_all'        => 'Tout supprimer',
        'save_and_edit'     => 'Appliquer et modifier',
        'save_and_story'    => 'Appliquer et voir',
        'show_hidden'       => 'Afficher les attributs cachés',
        'toggle_privacy'    => 'Privé/Public',
    ],
    'errors'        => [
        'loop'                  => 'Il y a une boucle sur la calculation de cet attribut!',
        'no_attribute_selected' => 'Sélectionner d\'abord un ou plusieurs attributs.',
        'too_many_v2'           => 'Le nombre maximum de champs est atteint (:count/:max). Supprimer d\'abord certains attributs avant de pouvoir en ajouter d\'autres.',
    ],
    'fields'        => [
        'attribute'             => 'Attribut',
        'community_templates'   => 'Modèles Communautaires',
        'is_private'            => 'Attributs privés',
        'is_star'               => 'Épinglé',
        'preferences'           => 'Préférences',
        'template'              => 'Modèle',
        'value'                 => 'Valeur',
    ],
    'filters'       => [
        'name'  => 'Nom d\'attribut',
        'value' => 'Valeur d\'attribut',
    ],
    'helpers'       => [
        'delete_all'    => 'Es-tu certain de vouloir supprimer tous les attributs de cette entité?',
        'is_private'    => 'Seulement permettre aux membres du rôle :admin-role de t voir les attributs de cette entité.',
        'setup'         => 'Tu peux représenter des valeurs comme les points de vie ou l\'intelligence d\'une entité avec les attributs. Ajoutes des attributs manuellement en cliquant le bouton :manage, ou applique ceux d\'un modèle d\'attributs.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Attributs modifiés pour :entity.',
        'title'     => 'Attributs pour :name',
    ],
    'labels'        => [
        'checkbox'  => 'Nom de la case à cocher',
        'name'      => 'Nom de l\'attribut',
        'section'   => 'Nom de la section',
        'value'     => 'Valeur de l\'attribut',
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
    'ranges'        => [
        'text'  => 'Options disponibles: :options',
    ],
    'sections'      => [
        'unorganised'   => 'Non organisé',
    ],
    'show'          => [
        'hidden'    => 'Attributs cachés',
        'title'     => 'Attributs de :name',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Modèle chargé',
            'title'     => 'Chargement à partir d\'un modèle',
        ],
        'success'   => 'Modèle d\'attribut :name appliqué pour :entity.',
        'title'     => 'Appliquer un modèle d\'attribut pour :name',
    ],
    'title'         => 'Attributs',
    'toasts'        => [
        'bulk_deleted'  => 'Attributs supprimés',
        'bulk_privacy'  => 'Attributs de privacité modifié',
        'lock'          => 'Attribut verouillé',
        'pin'           => 'Attribut épinglé',
        'unlock'        => 'Attribut déverouillé',
        'unpin'         => 'Attribut non-épinglé',
    ],
    'tutorials'     => [
        'character' => 'Par exemple, un personnage peut avoir une stat :hp et :str.',
        'general'   => 'Les attributs sont des petits bouts d\'information attachés à :name.',
        'location'  => 'Par exemple, ils peuvent avoir une stat :pop.',
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
