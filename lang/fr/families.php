<?php

return [
    'create'        => [
        'title' => 'Nouvelle Famille',
    ],
    'fields'        => [],
    'hints'         => [
        'is_extinct'    => 'Cette famille est éteinte.',
        'members'       => 'Les membres d\'une famille sont affichés ici. Un personnage peut être ajouté à une famille lors de l\'édition du personnage en utilisant le champ "Famille".',
    ],
    'members'       => [
        'create'    => [
            'helper'    => 'Ajouter un ou plusieurs membres à :name.',
            'success'   => '{0} Aucun membre ajouté.|{1} 1 membre ajouté.|[2,*] :count membres ajoutés.',
            'title'     => 'Nouveau membres',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nom de la famille',
        'type'  => 'Royale, Noble, Éteinte',
    ],
    'show'          => [
        'tabs'  => [
            'tree'  => 'Arbre de famille',
        ],
    ],
];
