<?php

return [
    'attribute_templates'   => [
        'title' => 'Modèles d\'attributs de :name',
    ],
    'create'                => [
        'description'   => 'Créer un nouveau Modèle d\'attribut',
        'success'       => 'Modèle d\'attribut \':name\' créé.',
        'title'         => 'Créer un nouveau Modèle d\'attribut',
    ],
    'destroy'               => [
        'success'   => 'Modèle d\'attribut \':name\' supprimé.',
    ],
    'edit'                  => [
        'description'   => 'Modifier un modèle d\'attribut',
        'success'       => 'Modèle d\'attribut \':name\' mis à jour.',
        'title'         => 'Modifier le modèle d\'attribut :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Modèle d\'attribut parent',
        'attributes'            => 'Attributs',
        'name'                  => 'Nom',
    ],
    'hints'                 => [
        'automatic'                 => 'Attributs automatiquement appliqués depuis le modèle :link.',
        'entity_type'               => 'Si défini, lors de la création d\'une nouvelle entité de ce type, ce modèle d\'attribut ainsi que ses parents seront automatiquement appliqués.',
        'parent_attribute_template' => 'Ce modèle d\'attribut peut être l\'enfant d\'un autre modèle d\'attribut. Lorsqu\'un modèle d\'attribut est appliqué, celui-ci ainsi que tous ses descendants seront aussi appliqués.',
    ],
    'index'                 => [
        'add'           => 'Nouveau modèle d\'attribut',
        'description'   => 'Gérer les modèles d\'attribut de :name.',
        'header'        => 'Modèle d\'attribut pour :name',
        'title'         => 'Modèle d\'attribut',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Choix d\'un modèle d\'attribut',
        'name'                  => 'Nom du modèle d\'attribut',
    ],
    'show'                  => [
        'description'   => 'Vue détaillée d\'un modèle d\'attribut',
        'tabs'          => [
            'attribute_templates'   => 'Modèles d\'attributs',
            'attributes'            => 'Attributs',
        ],
        'title'         => 'Modèle d\'attribut :name',
    ],
];
