<?php

return [
    'actions'       => [
        'add_appearance'    => 'Ajouter une apparence',
        'add_organisation'  => 'Ajouter une organisation',
        'add_personality'   => 'Ajouter un trait de personnalité',
    ],
    'conversations' => [
        'description'   => 'Conversations auxquelles la personne participe.',
        'title'         => 'Conversations de la personne :name',
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
        'description'   => 'Jet de dés attribué à la personne.',
        'hint'          => 'Les jets de dés peuvent être assigné à des personnes.',
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
        'free'  => 'Où est passé le champ "Texte Libre"? Si la personne en avait un, il a été déplacé sur le nouvel onglet "Notes".',
    ],
    'hints'         => [
        'hide_personality'          => 'Cet onglet peut être caché des membres non-Administrateur en désactivant l\'option "Personnalité Visible" lors de l\'édition de cette personne.',
        'is_dead'                   => 'Cette personne est morte.',
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
        'description'   => 'Objets tenus ou apparenant à la personne.',
        'hint'          => 'Des objets peuvent être assignés à des personnes et seront affichés ici.',
        'title'         => 'Objets de :name',
    ],
    'journals'      => [
        'description'   => 'Journaux dont l\'auteur est la personne.',
        'title'         => 'Journaux de :name',
    ],
    'maps'          => [
        'description'   => 'Visualisations des relations de la personne.',
        'title'         => 'Carte relationnelle de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Nouvelle organisation',
        ],
        'create'        => [
            'description'   => 'Associater une organisation à une personne',
            'success'       => 'Personne ajoutée à l\'organisation.',
            'title'         => 'Nouvelle Organisation pour :name',
        ],
        'description'   => 'Organisations dont la personne est un membre.',
        'destroy'       => [
            'success'   => 'Organisation de la personne supprimée.',
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
        'hint'          => 'Des personnes peuvent faire partie de nombreuses organisations, représentant leur employeur ou les sociétés auxquelles ils appartiennent.',
        'placeholders'  => [
            'organisation'  => 'Choix d\'une organisation...',
        ],
        'title'         => 'Organisations de :name',
    ],
    'placeholders'  => [
        'age'               => 'Age',
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
        'description'   => 'Quêtes auxquelles la personne est liée.',
        'helpers'       => [
            'quest_giver'   => 'Quêtes dont la personne est l\'auteur.',
            'quest_member'  => 'Quêtes dont la persone est membre.',
        ],
        'title'         => 'Quêtes de :name',
    ],
    'sections'      => [
        'appearance'    => 'Physique',
        'general'       => 'Inpourmation générale',
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
        'personality_hidden'    => 'Tu n\'as pas le droit de modifier les traits de personnalité de cette personne.',
    ],
];
