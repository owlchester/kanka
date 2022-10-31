<?php

return [
    'create'        => [
        'title' => 'Nouveau Journal',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Auteur',
        'date'      => 'Date',
        'journal'   => 'Journal parent',
        'journals'  => 'Sous-journaux',
    ],
    'helpers'       => [
        'journals'          => 'Afficher tous les sous-journaux de ce journal.',
        'nested_without'    => 'Affichage des journaux sans parent. Cliquer sur une rangée pour afficher les journaux enfants.',
    ],
    'index'         => [],
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
    ],
];
