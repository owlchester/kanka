<?php

return [
    'index' => [
        'title' => 'Notes',
        'description' => 'Gérer les notes de :name.',
        'add' => 'Nouvelle Note',
        'header' => 'Notes de :name',
    ],
    'create' => [
        'title' => 'Ajouter une note',
        'description' => '',
        'success' => 'Note \':name\' créée.',
    ],
    'show' => [
        'title' => 'Note :name',
        'description' => 'Détail de la note',
        'tabs' => [
            'description' => 'Description'
        ]
    ],
    'edit' => [
        'title' => 'Modifier Note :name',
        'description' => '',
        'success' => 'Note \':name\' modifiée.',
    ],
    'destroy' => [
        'success' => 'Note \':name\' supprimée.',
    ],

    'fields' => [
        'name' => 'Nom',
        'type' => 'Type',
        'image' => 'Image',
        'description' => 'Description',
    ],
    'placeholders' => [
        'name' => 'Nom de la note',
        'type' => 'Religion, Race, Moyen de transport',
    ],
];
