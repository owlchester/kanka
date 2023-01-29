<?php

return [
    'actions'           => [
        'customise' => 'Personnaliser la navigation',
    ],
    'create'            => [
        'title' => 'Nouveau Lien de menu',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Lien de menu :name',
    ],
    'fields'            => [
        'active'            => 'Actif',
        'dashboard'         => 'Tableau de bord',
        'default_dashboard' => 'Tableau de bord par défaut',
        'entity'            => 'Entité',
        'filters'           => 'Filtres',
        'is_nested'         => 'Vue imbriquée',
        'menu'              => 'Menu',
        'position'          => 'Position',
        'random'            => 'Aléatoire',
        'random_type'       => 'Type d\'entité aléatoire',
        'selector'          => 'Configuration du lien',
        'type'              => 'Entité Type',
    ],
    'helpers'           => [
        'active'            => 'Les liens rapides inactifs ne s\'affichent pas dans la navigation.',
        'dashboard'         => 'Mettre en place le lien de menu pour aller à un tableau de bord de la campagne. Cette fonctionnalité n\'est que disponible pour les :boosted.',
        'default_dashboard' => 'Lien vers le tableau de bord par défaut de la campagne. Un tableau de bord personnalisé doit encore être sélectionné.',
        'entity'            => 'Mettre en place ce lien de menu pour aller directement sur une entité. Le champ :tab contrôle quel onglet est ouvert. Le champ :menu contrôle quel sous-menu est affiché.',
        'position'          => 'Ce champ contrôle dans quel ordre les liens de menus apparaissent.',
        'random'            => 'Utilises ce champ pour avoir le lien de menu qui pointe vers une entité aléatoire. Le type d\'entité peut être filtré.',
        'selector'          => 'Configurer vers quel type d\'entité l\'utilisateur ira en cliquant sur le lien dans le menu de navigation.',
        'type'              => 'Définir ce lien de menu pour aller directement sur une liste d\'entité. Pour filtrer les résultats, il faut copier l\'url de la page filtrée après le :? de l\'url dans le champs :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'entity'    => 'Choix d\'une entité',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Sous-page (dernière partie de l\'url)',
        'name'      => 'Nom du lien de menu',
        'tab'       => 'entry, relations, notes, map',
    ],
    'random_no_entity'  => 'Aucune entité au hasard n\'a été trouvée.',
    'random_types'      => [
        'any'   => 'Toutes les entités',
    ],
    'reorder'           => [
        'success'   => 'Liens de menu réorganisés.',
        'title'     => 'Réorganiser les liens de menu',
    ],
    'show'              => [],
    'visibilities'      => [
        'is_active' => 'Afficher le liens dans la navigation',
    ],
];
