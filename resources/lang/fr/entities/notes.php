<?php

return [
    'actions'       => [
        'add'       => 'Ajouter une note',
        'add_user'  => 'Ajouter un membre',
    ],
    'create'        => [
        'description'   => 'Créer une nouvelle note',
        'success'       => 'Note \':name\' ajoutée à :entity.',
        'title'         => 'Nouvelle Note pour :name',
    ],
    'destroy'       => [
        'success'   => 'La note \':name\' a été retirée.',
    ],
    'edit'          => [
        'description'   => 'Modifier une note existante',
        'success'       => 'La note \':name\' pour :entity a été modifiée.',
        'title'         => 'Modifier la note pour :name',
    ],
    'fields'        => [
        'collapsed' => 'Fermer la note d\'entité par défault',
        'creator'   => 'Créé par',
        'entry'     => 'Entrée',
        'name'      => 'Nom',
    ],
    'hint'          => 'Les informations qui n\'entrent pas vraiment dans les champs pré-définis ou qui doivent être privées peuvent être ajoutées en tant que Note.',
    'hints'         => [
        'reorder'   => 'Les notes d\'entité peuvent être réarrangée en cliquant sur l\'icône :icon à côté de Histoire dans le menu de l\'entité.',
    ],
    'index'         => [
        'title' => 'Notes pour :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la note, observation ou remarque',
    ],
    'show'          => [
        'advanced'  => 'Permissions Avancées',
        'title'     => 'Note d\'entité :name pour :entity',
    ],
];
