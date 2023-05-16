<?php

return [
    'actions'   => [
        'customise' => 'Personnaliser',
    ],
    'fields'    => [
        'icon'      => 'Icône du module',
        'plural'    => 'Nom au pluriel du module',
        'singular'  => 'Nom au singulier du module',
    ],
    'helpers'   => [
        'info'  => 'Une campagne est compromise de plusieurs modules qui interagissent entre eux. Il est possible d\'activer ou de désactiver les modules qui ne sont pas utiles pour la campagne. Désactiver un module ne supprime aucune de ses données, mais cache simplement l\'information.',
    ],
    'pitch'     => 'Renommer et changer l\'icône associée à ce module pour l\'ensemble de la campagne.',
    'rename'    => [
        'helper'    => 'Modifier le nom et l\'icône du module tout au long de la campagne. Laisser vide pour utiliser le nom par défaut de Kanka.',
        'success'   => 'Module personnalisé.',
        'title'     => 'Personnaliser le module :module',
    ],
    'reset'     => [
        'success'   => 'Les modules de la campagne ont été réinitialisé.',
        'title'     => 'Réinitialiser des noms et icônes personnalisés des modules',
        'warning'   => 'Es-tu ous sûr de vouloir rétablir les noms et icônes d\'origine des modules de la campagne=',
    ],
    'states'    => [
        'disable'   => 'Désactiver',
        'enable'    => 'Activer',
    ],
];
