<?php

return [
    'create'        => [
        'title' => 'Nouvelle Note',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Sous-notes',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage des notes sans parent. Cliquer sur une rangée pour afficher les notes enfants.',
    ],
    'hints'         => [
        'is_pinned' => 'Jusqu\'à 3 notes peuvent être affichées sur le tableau de bord en les épinglant.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Choix d\'une note parent',
        'type'  => 'Religion, Race, Moyen de transport',
    ],
    'show'          => [],
];
