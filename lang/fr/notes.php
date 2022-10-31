<?php

return [
    'create'        => [
        'title' => 'Nouvelle Note',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Épinglé',
        'note'      => 'Note parent',
        'notes'     => 'Sous-notes',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage des notes sans parent. Cliquer sur une rangée pour afficher les notes enfants.',
    ],
    'hints'         => [
        'is_pinned' => 'Jusqu\'à 3 notes peuvent être affichées sur le tableau de bord en les épinglant.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nom de la note',
        'note'  => 'Choix d\'une note parent',
        'type'  => 'Religion, Race, Moyen de transport',
    ],
    'show'          => [],
];
