<?php

return [
    'actions'       => [
        'add_appearance'    => 'Ajouter une apparence',
        'add_organisation'  => 'Ajouter une organisation',
        'add_personality'   => 'Ajouter un trait de personnalité',
    ],
    'conversations' => [
        'description'   => 'Conversations auxquelles le personnage participe.',
        'title'         => 'Conversations du personnage :name',
    ],
    'create'        => [
        'description'   => 'Créer une nouvelle personne',
        'success'       => 'Personne \':name\' créée.',
        'title'         => 'Créer une nouvelle personne',
    ],
    'destroy'       => [
        'success'   => 'Personne \':name\' supprimée.',
    ],
    'dice_rolls'    => [
        'description'   => 'Jet de dés attribué au personnage.',
        'hint'          => 'Les jets de dés peuvent être assignés à des personnages.',
        'title'         => 'Jet de dés de :name',
    ],
    'edit'          => [
        'description'   => 'Modifier une personne',
        'success'       => 'Personne \':name\' modifiée.',
        'title'         => 'Modifier Personne :name',
    ],
    'fields'        => [
        'age'                       => 'Age',
        'family'                    => 'Famille',
        'image'                     => 'Image',
        'is_dead'                   => 'Mort',
        'is_personality_visible'    => 'Personnalité visible',
        'life'                      => 'Vie',
        'location'                  => 'Lieu',
        'name'                      => 'Nom',
        'physical'                  => 'Physique',
        'race'                      => 'Race',
        'relation'                  => 'Relation',
        'sex'                       => 'Sexe',
        'title'                     => 'Titre',
        'traits'                    => 'Traits',
        'type'                      => 'Type',
    ],
    'helpers'       => [
        'age'   => 'Il est possible de lier cette entité avec un calendrier de la campagne pour automatiquement calculer l\'âge. :more.',
    ],
    'hints'         => [
        'hide_personality'          => 'Cet onglet peut être caché des membres non-Administrateur en désactivant l\'option "Personnalité Visible" lors de l\'édition de ce personnage.',
        'is_dead'                   => 'Ce personnage est mort.',
        'is_personality_visible'    => 'Tu peux cacher toute la personnalité des membres de type non Admin.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Nouvelle Personne Aléatoire',
        ],
        'add'           => 'Nouvelle Personne',
        'description'   => 'Gérer les personnes de :name.',
        'header'        => 'Personnes de :name',
        'title'         => 'Personnes',
    ],
    'items'         => [
        'description'   => 'Objets tenus ou appartenant au personnage.',
        'hint'          => 'Des objets peuvent être assignés à des personnages et seront affichés ici.',
        'title'         => 'Objets de :name',
    ],
    'journals'      => [
        'description'   => 'Journaux dont l\'auteur est le personnage.',
        'title'         => 'Journaux de :name',
    ],
    'maps'          => [
        'description'   => 'Visualisations des relations du personnage.',
        'title'         => 'Carte relationnelle de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Nouvelle organisation',
        ],
        'create'        => [
            'description'   => 'Associer une organisation à une personne',
            'success'       => 'Personne ajoutée à l\'organisation.',
            'title'         => 'Nouvelle Organisation pour :name',
        ],
        'description'   => 'Organisations dont le personnage est membre.',
        'destroy'       => [
            'success'   => 'Organisation de personne supprimée.',
        ],
        'edit'          => [
            'description'   => 'Modifier l\'organisation d\'une personne',
            'success'       => 'Organisation de personne modifiée.',
            'title'         => 'Modifier l\'Organisation pour :name',
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
        'race'              => 'Race',
        'sex'               => 'Sexe',
        'title'             => 'Titre',
        'traits'            => 'Traits',
        'type'              => 'PNJ, Joueurs, Autre',
    ],
    'quests'        => [
        'description'   => 'Quêtes auxquelles le personnage est lié.',
        'helpers'       => [
            'quest_giver'   => 'Quêtes dont le personnage est l\'auteur.',
            'quest_member'  => 'Quêtes dont le personnage est membre.',
        ],
        'title'         => 'Quêtes de :name',
    ],
    'sections'      => [
        'appearance'    => 'Physique',
        'general'       => 'Information générale',
        'personality'   => 'Personnalité',
    ],
    'show'          => [
        'description'   => 'Détail d\'une personne',
        'tabs'          => [
            'conversations' => 'Conversations',
            'dice_rolls'    => 'Jets de dés',
            'items'         => 'Objets',
            'journals'      => 'Journaux',
            'map'           => 'Carte Relationnelle',
            'organisations' => 'Organisations',
            'personality'   => 'Personnalité',
            'quests'        => 'Quêtes',
        ],
        'title'         => 'Personne :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Tu n\'as pas le droit de modifier les traits de personnalité de ce personnage.',
    ],
];
