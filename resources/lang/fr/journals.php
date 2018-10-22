<?php

return [
    'create'        => [
        'description'   => 'Créer un nouveau journal',
        'success'       => 'Journal créé.',
        'title'         => 'Nouveau Journal',
    ],
    'destroy'       => [
        'success'   => 'Journal supprimé.',
    ],
    'edit'          => [
        'success'   => 'Journal modifié.',
        'title'     => 'Modifier Journal :name',
    ],
    'fields'        => [
        'author'    => 'Auteur',
        'date'      => 'Date',
        'image'     => 'Image',
        'name'      => 'Nom',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'Nouveau Journal',
        'description'   => 'Gérer les journaux de :name.',
        'header'        => 'Journaux de :name',
        'title'         => 'Journaux',
    ],
    'placeholders'  => [
        'author'    => 'Qui a écrit le journal',
        'date'      => 'Date du journal',
        'name'      => 'Nom du journal',
        'type'      => 'Session, One Shot, Brouillon',
    ],
    'show'          => [
        'description'   => 'Détail d\'un journal',
        'title'         => 'Journal :name',
    ],
];
