<?php

return [
    'actions'   => [
        'add'               => 'Ajouter un pouvoir',
        'import_from_race'  => 'Ajouter les pouvoirs de la race',
        'reset'             => 'Réinitialiser les charges',
    ],
    'create'    => [
        'success'           => 'Pouvoir :ability ajouté à :entity.',
        'success_multiple'  => 'Les pouvoirs :abilities ont été ajouté à :entity.',
        'title'             => 'Ajouter un pouvoir à :name',
    ],
    'fields'    => [
        'note'      => 'Note',
        'position'  => 'Position',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Ce personnage n\'as pas de race.',
            'not_character' => 'Cette entité n\'est pas un personnage.',
        ],
        'success'   => '{1} :count pouvoir ajouté.|[2,*] :count pouvoirs ajoutés.',
    ],
    'show'      => [
        'helper'    => 'Attache des pouvoirs à cette entité. Il est toujours possible de modifier ou de supprimer un pouvoir. Les pouvoirs qui appartiennent au même parent sont groupés ensemble et agissent comme filtres.',
        'title'     => 'Pouvoirs de l\'entité :name',
    ],
    'update'    => [
        'title' => 'Pouvoirs de l\'entité :name',
    ],
];
