<?php

return [
    'helpers'   => [
        'admin'         => 'Seul les membres du rôle admin de la campagne voient cet élément.',
        'admin-self'    => 'Une combination des visibilités :admin et :self.',
        'all'           => 'Tout le monde peut voir cet élément.',
        'entities'      => 'En plus de la valeur de visibilité de l\'élément, s\'il est lié à une entité, la permission de l\'entité entrera également en jeu. Par exemple, si une relation est visible par tous, mais que la cible de la relation n\'est visible que par les admins, seuls les admins verront la relation.',
        'intro'         => 'De nombreux éléments dans Kanka ont une option de visibilité, permettant de contrôler qui voit quoi sans avoir à configurer des autorisations complexes.',
        'members'       => 'Seul les membres de la campagne voient cet élément. Pratique pour une campagne public où les membres ont plus d\'accès qu\'un utilisateur publique.',
        'options'       => 'Voici une liste détaillant ce que chaque visibilité fait.',
        'self'          => 'Seulement l\'utilisateur qui a créé l\'élément le voit.',
        'title'         => 'Visibilité',
    ],
    'tooltip'   => 'Cliquer pour connaître les options de visibilité.',
];
