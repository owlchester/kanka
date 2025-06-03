<?php

return [
    'create'        => [
        'title' => 'Nouvelle Race',
    ],
    'fields'        => [
        'members'   => 'Membres',
    ],
    'hints'         => [
        'is_extinct'    => 'Cette race est éteinte.',
    ],
    'members'       => [
        'create'    => [
            'helper'    => 'Ajouter un ou plusieurs personnages à :name.',
            'submit'    => 'Ajouter membres',
            'success'   => '{0} Aucun membre ajouté.|{1} 1 membre ajouté.|[2,*] :count membres ajoutés.',
            'title'     => 'Nouveaux membres',
        ],
    ],
    'placeholders'  => [
        'type'  => 'Humain, Fée, Borg',
    ],
];
