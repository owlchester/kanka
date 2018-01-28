<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Note \':name\' créée.',
        'title'         => 'Ajouter une note',
    ],
    'destroy'       => [
        'success'   => 'Note \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Note \':name\' modifiée.',
        'title'         => 'Modifier Note :name',
    ],
    'fields'        => [
        'description'   => 'Description',
        'image'         => 'Image',
        'name'          => 'Nom',
        'type'          => 'Type',
    ],
    'index'         => [
        'add'           => 'Nouvelle Note',
        'description'   => 'Gérer les notes de :name.',
        'header'        => 'Notes de :name',
        'title'         => 'Notes',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la note',
        'type'  => 'Religion, Race, Moyen de transport',
    ],
    'show'          => [
        'description'   => 'Détail de la note',
        'tabs'          => [
            'description'   => 'Description',
        ],
        'title'         => 'Note :name',
    ],
];
