<?php

return [
    'create'        => [
        'success'   => 'Journal créé.',
        'title'     => 'Nouveau Journal',
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
        'journals'      => 'Afficher tous les sous-journaux de ce journal.',
        'nested_parent' => 'Affichage des journaux de :parent.',
        'nested_without'=> 'Affichage des journaux sans parent. Cliquer sur une rangée pour afficher les journaux enfants.',
    ],
    'index'         => [
        'add'       => 'Nouveau Journal',
        'header'    => 'Journaux de :name',
        'title'     => 'Journaux',
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
        'tabs'  => [
            'journals'  => 'Journaux',
        ],
        'title' => 'Journal :name',
    ],
];
