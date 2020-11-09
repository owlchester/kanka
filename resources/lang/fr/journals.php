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
        'journal'   => 'Journal parent',
        'journals'  => 'Sous-journaux',
        'name'      => 'Nom',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'journals'  => 'Afficher tous les sous-journaux de ce journal.',
        'nested'    => 'Affichage des journaux sans journal parent. Cliquer sur une ligne affiche les sous-journaux.',
    ],
    'index'         => [
        'add'           => 'Nouveau Journal',
        'description'   => 'Gérer les journaux de :name.',
        'header'        => 'Journaux de :name',
        'title'         => 'Journaux',
    ],
    'journals'      => [
        'title' => 'Sous-journaux du journal :name',
    ],
    'placeholders'  => [
        'author'    => 'Qui a écrit le journal',
        'date'      => 'Date du journal',
        'journal'   => 'Choix d\'un journal parent',
        'name'      => 'Nom du journal',
        'type'      => 'Session, One Shot, Brouillon',
    ],
    'show'          => [
        'description'   => 'Détail d\'un journal',
        'tabs'          => [
            'journals'  => 'Journaux',
        ],
        'title'         => 'Journal :name',
    ],
];
