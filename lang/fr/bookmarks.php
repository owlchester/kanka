<?php

return [
    'actions'           => [
        'customise' => 'Personnaliser la navigation',
    ],
    'create'            => [
        'title' => 'Nouveau favori',
    ],
    'edit'              => [
        'title' => 'Favori :name',
    ],
    'fields'            => [
        'active'            => 'Actif',
        'dashboard'         => 'Tableau de bord',
        'default_dashboard' => 'Tableau de bord par défaut',
        'filters'           => 'Filtres',
        'menu'              => 'Menu',
        'position'          => 'Position',
        'random_type'       => 'Type d\'entité aléatoire',
        'selector'          => 'Configuration du favori',
        'target'            => 'Cible',
    ],
    'helpers'           => [
        'active'            => 'Les favoris inactifs ne s\'affichent pas dans la navigation.',
        'css'               => 'Ajoutes une classe CSS qui sera ajoutée au lien du bookmark dans la navigation.',
        'dashboard'         => 'Mettre en place le favori pour aller à un tableau de bord.',
        'default_dashboard' => 'Favori vers le tableau de bord par défaut de la campagne. Un tableau de bord personnalisé doit encore être sélectionné.',
        'entity'            => 'Mettre en place le favori pour aller directement sur une entité. Le champ :tab contrôle quel onglet est ouvert. Le champ :menu contrôle quel sous-menu est affiché.',
        'position'          => 'Ce champ contrôle dans quel ordre les favoris apparaissent.',
        'random'            => 'Utilises ce champ pour avoir le favori qui pointe vers une entité aléatoire. Le type d\'entité peut être filtré.',
        'selector'          => 'Configurer vers quel type d\'entité l\'utilisateur ira en cliquant sur le favori dans le menu de navigation.',
        'type'              => 'Définir ce favori pour aller directement sur une liste d\'entité. Pour filtrer les résultats, il faut copier l\'url de la page filtrée après le :? de l\'url dans le champs :filter.',
    ],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Sous-page (dernière partie de l\'url)',
        'tab'       => 'entry, relations, notes, map',
    ],
    'random_no_entity'  => 'Aucune entité au hasard n\'a été trouvée.',
    'random_types'      => [
        'any'   => 'Toutes les entités',
    ],
    'reorder'           => [
        'success'   => 'Favoris réorganisés.',
        'title'     => 'Réorganiser les favoris',
    ],
    'targets'           => [
        'dashboard' => 'Un des tableaux de bord de la campagne',
        'entity'    => 'Une seule entité',
        'random'    => 'Une entité au hasard',
        'select'    => 'Choisir une option',
        'type'      => 'Liste des entités d\'un type/module d\'entité spécifique',
    ],
    'visibilities'      => [
        'is_active' => 'Afficher le favori dans la navigation',
    ],
];
