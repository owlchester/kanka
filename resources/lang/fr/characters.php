<?php

return [
    'actions'       => [
        'add_appearance'    => 'Ajouter une apparence',
        'add_organisation'  => 'Ajouter une organisation',
        'add_personality'   => 'Ajouter un trait de personnalité',
    ],
    'conversations' => [
        'title' => 'Conversations du personnage :name',
    ],
    'create'        => [
        'success'   => 'Personne \':name\' créée.',
        'title'     => 'Créer une nouvelle personne',
    ],
    'destroy'       => [
        'success'   => 'Personne \':name\' supprimée.',
    ],
    'dice_rolls'    => [
        'hint'  => 'Les jets de dés peuvent être assignés à des personnages.',
        'title' => 'Jet de dés de :name',
    ],
    'edit'          => [
        'success'   => 'Personne \':name\' modifiée.',
        'title'     => 'Modifier Personne :name',
    ],
    'fields'        => [
        'age'                       => 'Age',
        'families'                  => 'Familles',
        'family'                    => 'Famille',
        'image'                     => 'Image',
        'is_appearance_pinned'      => 'Physique épinglé',
        'is_dead'                   => 'Mort',
        'is_personality_pinned'     => 'Personnalité épinglée',
        'is_personality_visible'    => 'Personnalité visible',
        'life'                      => 'Vie',
        'location'                  => 'Lieu',
        'name'                      => 'Nom',
        'physical'                  => 'Physique',
        'pronouns'                  => 'Pronoms',
        'race'                      => 'Race',
        'races'                     => 'Races',
        'sex'                       => 'Sexe',
        'title'                     => 'Titre',
        'traits'                    => 'Traits',
        'type'                      => 'Type',
    ],
    'helpers'       => [
        'age'   => 'Il est possible de lier cette entité avec un calendrier de la campagne pour automatiquement calculer l\'âge. :more.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Si sélectionné, le physique du personnage sera visible sur la page vue d\'ensemble sous l\'entrée.',
        'is_dead'                   => 'Ce personnage est mort.',
        'is_personality_pinned'     => 'Si sélectionné, la personnalité du personnage sera visible sur la page vue d\'ensemble sous l\'entrée.',
        'is_personality_visible'    => 'Tu peux cacher toute la personnalité des membres de type non Admin.',
        'personality_not_visible'   => 'Les traits de personnalités de ce personnage sont actuellement seulement visibles pour les Admin de la campagne.',
        'personality_visible'       => 'Les traits de personnalités sont visibles pour tous.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'Nouvelle Personne Aléatoire',
        ],
        'title'     => 'Personnes',
    ],
    'items'         => [
        'hint'  => 'Des objets peuvent être assignés à des personnages et seront affichés ici.',
        'title' => 'Objets de :name',
    ],
    'journals'      => [
        'title' => 'Journaux de :name',
    ],
    'maps'          => [
        'title' => 'Carte relationnelle de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Nouvelle organisation',
        ],
        'create'        => [
            'success'   => 'Personne ajoutée à l\'organisation.',
            'title'     => 'Nouvelle Organisation pour :name',
        ],
        'destroy'       => [
            'success'   => 'Organisation de personne supprimée.',
        ],
        'edit'          => [
            'success'   => 'Organisation de personne modifiée.',
            'title'     => 'Modifier l\'Organisation pour :name',
        ],
        'fields'        => [
            'organisation'  => 'Organisation',
            'role'          => 'Rôle',
        ],
        'hint'          => 'Les personnages peuvent faire partie de nombreuses organisations, représentant leur employeur ou les sociétés auxquelles ils appartiennent.',
        'placeholders'  => [
            'organisation'  => 'Choix d\'une organisation...',
        ],
        'title'         => 'Organisations de :name',
    ],
    'placeholders'  => [
        'age'               => 'Âge',
        'appearance_entry'  => 'Description',
        'appearance_name'   => 'Cheveux, Yeux, Peau, Taille',
        'family'            => 'Choix d\'une famille',
        'image'             => 'Image',
        'location'          => 'Choix du lieu',
        'name'              => 'Nom',
        'personality_entry' => 'Détails',
        'personality_name'  => 'Trait de personnalité: objectifs, maniérismes, peurs, liens',
        'physical'          => 'Physique',
        'pronouns'          => 'Il, Elle',
        'race'              => 'Race',
        'races'             => 'Choix de races',
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
    'sections'      => [
        'appearance'    => 'Physique',
        'general'       => 'Information générale',
        'personality'   => 'Personnalité',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organisations',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'Tu n\'as pas le droit de modifier les traits de personnalité de ce personnage.',
    ],
];
