<?php

return [
    'actions'       => [
        'add_appearance'    => 'Ajouter une apparence',
        'add_personality'   => 'Ajouter un trait de personnalité',
    ],
    'create'        => [
        'title' => 'Créer une nouvelle personne',
    ],
    'families'      => [
        'helper'    => 'Réorganise et contrôle quelles familles de :name sont visibles ou cachées aux non-admins.',
        'reorder'   => [
            'success'   => 'Les familles du personage ont été mises à jour avec succès.',
        ],
        'title2'    => 'Gérer les familles',
    ],
    'fields'        => [
        'age'                       => 'Age',
        'is_appearance_pinned'      => 'Physique épinglé',
        'is_dead'                   => 'Mort',
        'is_personality_pinned'     => 'Personnalité épinglée',
        'is_personality_visible'    => 'Personnalité visible',
        'life'                      => 'Vie',
        'physical'                  => 'Physique',
        'pronouns'                  => 'Pronoms',
        'sex'                       => 'Sexe',
        'title'                     => 'Titre',
        'traits'                    => 'Traits',
    ],
    'helpers'       => [
        'age'                   => 'Il est possible de lier cette entité avec un calendrier de la campagne pour automatiquement calculer l\'âge. :more.',
        'personality_visible'   => 'Si coché, les traits de personnalités seront visibles pour tous. Sinon, seuls les membres du rôle :admin de la campagne pourront voir les traits de personnalité de ce personnage.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Si sélectionné, le physique du personnage sera visible sur la page vue d\'ensemble sous l\'entrée.',
        'is_dead'                   => 'Ce personnage est mort.',
        'is_personality_pinned'     => 'Si sélectionné, la personnalité du personnage sera visible sur la page vue d\'ensemble sous l\'entrée.',
        'is_personality_visible'    => 'Tout le monde peut voir les traits de personmalités de ce personnage.',
        'personality_not_visible'   => 'Les traits de personnalités de ce personnage sont actuellement seulement visibles pour les admin de la campagne.',
        'personality_visible'       => 'Les traits de personnalités sont visibles pour tous.',
    ],
    'labels'        => [
        'appearance'    => [
            'entry' => 'Description de l\'apparance',
            'name'  => 'Nom de l\'apparance',
        ],
        'personality'   => [
            'entry' => 'Description du trait de personnalité',
            'name'  => 'Nom du trait de personnalité',
        ],
    ],
    'organisations' => [
        'create'    => [
            'success'   => 'Personne ajoutée à l\'organisation.',
            'title'     => 'Nouvelle Organisation pour :name',
        ],
        'destroy'   => [
            'success'   => 'Organisation de personne supprimée.',
        ],
        'edit'      => [
            'success'   => 'Organisation de personne modifiée.',
            'title'     => 'Modifier l\'Organisation pour :name',
        ],
        'fields'    => [
            'role'  => 'Rôle',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Âge',
        'appearance_entry'  => 'Description',
        'appearance_name'   => 'Cheveux, Yeux, Peau, Taille',
        'name'              => 'Nom du personnage',
        'personality_entry' => 'Détails',
        'personality_name'  => 'Trait de personnalité: objectifs, maniérismes, peurs, liens',
        'physical'          => 'Physique',
        'pronouns'          => 'Il, Elle',
        'sex'               => 'Sexe',
        'title'             => 'Titre',
        'traits'            => 'Traits',
        'type'              => 'PNJ, Joueurs, Autre',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Quêtes dont le personnage est l\'auteur.',
            'quest_member'  => 'Quêtes dont le personnage est membre.',
        ],
    ],
    'races'         => [
        'helper'    => 'Réorganise et contrôle quelles races de :name sont visibles ou cachées aux non-admins.',
        'reorder'   => [
            'success'   => 'Mise à jour réussie des races de personnage.',
        ],
        'title2'    => 'Gérer les races',
    ],
    'sections'      => [
        'appearance'    => 'Physique',
        'personality'   => 'Personnalité',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Tu n\'as pas le droit de modifier les traits de personnalité de ce personnage.',
    ],
];
