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
    ],
    'helpers'       => [
        'journals'          => 'Afficher tous les sous-journaux de ce journal.',
        'nested_without'    => 'Affichage des journaux sans parent. Cliquer sur une rangée pour afficher les journaux enfants.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Qui a écrit le journal',
        'date'      => 'Date du journal',
        'type'      => 'Session, One Shot, Brouillon',
    ],
    'show'          => [],
];
