<?php

return [
    'actions'   => [
        'show-old'  => 'Modifications',
    ],
    'cta'       => 'Afficher un journal de toutes les modifications récentes faites à la campagne.',
    'filters'   => [
        'all-actions'   => 'Toutes les actions',
        'all-users'     => 'Tous les membres',
        'no-results'    => 'Aucun résultat à afficher. Essayes avec d\'autres filtres ou reviens après avoir fait des modifications aux entités de la campagne.',
    ],
    'helpers'   => [
        'base'      => 'Cette interface contient les modifications récentes apportées aux entités de la campagne jusqu\'à :amount mois, en affichant les modifications les plus récentes en premier.',
        'changes'   => 'Les champs suivants avaient précédemment ces valeurs.',
    ],
    'log'       => [
        'create'    => 'L\'utilisateur :user a créé :entity',
        'delete'    => 'L\'utilisateur :user a supprimé :entity',
        'restore'   => 'L\'utilisateur :user a restauré :entity',
        'update'    => 'L\'utilisateur :user a modifié :entity',
    ],
    'title'     => 'Histoires',
    'unknown'   => [
        'entity'    => 'une entité inconnue',
    ],
];
