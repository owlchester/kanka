<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Journal créé.',
        'title'         => 'Ajouter un journal',
    ],
    'destroy'       => [
        'success'   => 'Journal supprimé.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Journal modifié.',
        'title'         => 'Modifier Journal :name',
    ],
    'fields'        => [
        'date'      => 'Date',
        'history'   => 'Histoire',
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
        'date'  => 'Date du journal',
        'name'  => 'Nom du journal',
        'type'  => 'Session, One Shot, Brouillon',
    ],
    'show'          => [
        'description'   => 'Détail d\'un journal',
        'title'         => 'Journal :name',
    ],
];
