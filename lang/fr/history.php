<?php

return [
    'actions'   => [
        'show-old'  => 'Modifications',
    ],
    'cta'       => 'Afficher un journal de toutes les modifications récentes faites à la campagne.',
    'empty'     => 'Aucune valeure',
    'fields'    => [
        'action'    => 'Action',
        'details'   => 'Détails',
        'module'    => 'Module',
        'when'      => 'Quand',
        'who'       => 'Qui',
    ],
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
        'create'        => ':user a créé :entity',
        'create_post'   => ':user a créé la note ":post" sur :entity',
        'delete'        => ':user a supprimé :entity',
        'delete_post'   => ':user a supprimé une note sur :entity',
        'reorder_post'  => ':user a réordonné les articles sur :entity',
        'restore'       => ':user a restauré :entity',
        'update'        => ':user a modifié :entity',
        'update_post'   => ':user a supprimé la note ":post" sur :entity',
        'update_tree'   => ':user a modifié l\'arbre de famille de :entity',
    ],
    'title'     => 'Historique',
    'unknown'   => [
        'entity'    => 'une entité inconnue',
    ],
];
