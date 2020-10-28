<?php

return [
    'actions'       => [
        'add'   => 'Ajouter un nouveau groupe',
    ],
    'create'        => [
        'success'   => 'Groupe :name créé.',
        'title'     => 'Nouveau Groupe',
    ],
    'delete'        => [
        'success'   => 'Groupe :name supprimé.',
    ],
    'edit'          => [
        'success'   => 'Groupe :name modifié.',
        'title'     => 'Modifier le groupe :name',
    ],
    'fields'        => [
        'is_shown'  => 'Afficher les marqueurs du groupe',
        'position'  => 'Position',
    ],
    'helper'        => [
        'amount'            => 'Un marqueur peut être attaché à un groupe, permettant d\'afficher ou de cacher tous les marqueurs d\'un groupe à la fois (par exemple tous les marqueurs attachés au groupe Magasins). Une carte peut avoir jusqu\'à :amount groupes.',
        'boosted_campaign'  => 'Les cartes :boosted peuvent avoir jusqu\'à :amount groupes.',
    ],
    'hints'         => [
        'is_shown'  => 'Si sélectionné, les marqueurs du groups seront affichés par défaut.',
    ],
    'placeholders'  => [
        'name'      => 'Magasins, trésors, PNJs',
        'position'  => 'Champ optionnel pour définir l\'ordre dans lequel s\'affichent les groupes.',
    ],
];
