<?php

return [
    'actions'       => [
        'apply_kit'     => 'Appliquer un kit de propriétés',
        'load'          => 'Charger',
        'manage'        => 'Gérer',
        'more'          => 'Plus d\'options',
        'remove_all'    => 'Tout supprimer',
        'save_and_edit' => 'Appliquer et modifier',
        'save_and_story'=> 'Appliquer et voir',
        'show_hidden'   => 'Afficher les propriétés cachées',
        'toggle_privacy'=> 'Privé/Public',
    ],
    'errors'        => [
        'api'                   => 'Données invalides',
        'loop'                  => 'Il y a une boucle sur la calculation de cette propriété!',
        'no_attribute_selected' => 'Sélectionner d\'abord une ou plusieurs propriétés.',
        'too_many_v2'           => 'Le nombre maximum de champs est atteint (:count/:max). Supprimer d\'abord certaines propriétés avant de pouvoir en ajouter d\'autres.',
    ],
    'fields'        => [
        'community_templates'   => 'Modèles Communautaires',
        'is_private'            => 'Propriétés privées',
        'is_star'               => 'Épinglé',
        'preferences'           => 'Préférences',
        'property'              => 'Propriété',
        'template'              => 'Kit',
        'value'                 => 'Valeur',
    ],
    'filters'       => [
        'name'  => 'Nom de la propriété',
        'value' => 'Valeur de la propriété',
    ],
    'helpers'       => [
        'delete_all'    => 'Es-tu certain de vouloir supprimer toutes les propriétés de cette entrée?',
        'is_private'    => 'Seulement permettre aux membres du rôle :admin-role de voir les propriétés de cette entrée.',
        'setup'         => 'Tu peux représenter des valeurs comme les points de vie ou l\'intelligence d\'une entrée avec les propriétés. Ajoutes des propriétés manuellement en cliquant le bouton :manage, ou applique ceux d\'un kit de propriétés.',
    ],
    'index'         => [
        'success'   => 'Propriétés modifiées pour :entity.',
        'title'     => 'Propriétés pour :name',
    ],
    'labels'        => [
        'checkbox'  => 'Nom de la case à cocher',
        'name'      => 'Nom de la propriété',
        'section'   => 'Nom de la section',
        'value'     => 'Valeur de la propriété',
    ],
    'live'          => [
        'success'   => 'Propriété :attribute modifiée.',
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
            'name'  => 'Nom de la propriété',
            'value' => '1-100 ou une liste de valeurs séparées par une virgule',
        ],
        'section'   => 'Nom de la section',
        'template'  => 'Sélectionner un modèle',
        'value'     => 'Valeur de la propriété',
    ],
    'ranges'        => [
        'text'  => 'Options disponibles: :options',
    ],
    'sections'      => [
        'unorganised'   => 'Non organisé',
    ],
    'show'          => [
        'hidden'    => 'Propriétés cachées',
        'title'     => 'Propriétés de :name',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Modèle chargé',
            'title'     => 'Chargement à partir d\'un modèle',
        ],
        'pitch'     => 'Charge les propriétés depuis un kit de propriétés ou depuis les plugins installés via :plugin.',
        'success'   => 'Kit de propriétés :name appliqué pour :entity.',
        'title'     => 'Appliquer un kit de propriétés pour :name',
    ],
    'title'         => 'Propriétés',
    'toasts'        => [
        'bulk_deleted'  => 'Propriétés supprimés',
        'bulk_privacy'  => 'Propriétés de privacité modifié',
        'lock'          => 'Propriété verouillé',
        'pin'           => 'Propriété épinglé',
        'unlock'        => 'Propriété déverouillé',
        'unpin'         => 'Propriété non-épinglé',
    ],
    'tutorials'     => [],
    'types'         => [
        'attribute' => 'Texte',
        'block'     => 'Bloc',
        'checkbox'  => 'Case à cocher',
        'icon'      => 'Icône',
        'kits'      => 'Kits',
        'number'    => 'Nombre',
        'random'    => 'Aléatoire',
        'section'   => 'Section',
        'text'      => 'Texte multiligne',
    ],
    'update'        => [
        'success'   => 'Les propriétés de :entity ont été modifiées.',
    ],
    'visibility'    => [
        'entry'     => 'Propriété affiché sur le menu d\'entrée.',
        'private'   => 'Propriété seulement visible aux membres du rôle "Admin".',
        'public'    => 'Propriété visible par tous les membres.',
        'tab'       => 'Propriété visible sous l\'onglet Propriétés.',
    ],
];
