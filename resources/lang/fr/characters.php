<?php

return [
    'index' => [
        'title' => 'Personnes',
        'description' => 'Gérer les personnes de :name.',
        'add' => 'Nouvelle Personne',
        'header' => 'Personnes de :name',
        'actions' => [
            'random' => 'Nouvelle Personne Aléatoire',
        ]
    ],
    'create' => [
        'title' => 'Créer une nouvelle personne',
        'description' => '',
        'success' => 'Personne \':name\' créée.',
    ],
    'show' => [
        'title' => 'Personne :name',
        'description' => 'Détail d\'une personne',
        'tabs' => [
            'history' => 'Histoire',
            'personality' => 'Personnalité',
            'free' => 'Texte libre',
            'relations' => 'Relations',
            'organisations' => 'Organisations',
            'attributs' => 'Attributs',
        ]
    ],
    'edit' => [
        'title' => 'Modifier Personne :name',
        'description' => '',
        'success' => 'Personne \':name\' modifiée.',
    ],
    'destroy' => [
        'success' => 'Personne \':name\' supprimée.',
    ],
    'fields' =>  [
        'name' => 'Nom',
        'title' => 'Titre',
        'age' => 'Age',
        'sex' => 'Sexe',
        'height' => 'Taille',
        'weight' => 'Poid',
        'eye' => 'Couleur des yeux',
        'hair' => 'Cheveux',
        'skin' => 'Peau',
        'languages' => 'Langues',
        'race' => 'Race',
        'location' => 'Lieu',
        'relation' => 'Relation',
        'family' => 'Famille',
        'physical' => 'Physique',
        'goals' => 'Objectifs',
        'traits' => 'Traits',
        'fears' => 'Craine',
        'free' => 'Texte libre',
        'mannerisms' => 'Maniérismes',
        'history' => 'Histoire',
        'image' => 'Image',
        'is_personality_visible' => 'Personnalité visible',
    ],
    'placeholders' => [
        'name' => 'Nom',
        'title' => 'Titre',
        'age' => 'Age',
        'sex' => 'Sexe',
        'height' => 'Taille',
        'weight' => 'Poid',
        'eye' => 'Couleur des yeux',
        'hair' => 'Cheveux',
        'skin' => 'Peau',
        'languages' => 'Langues',
        'race' => 'Race',
        'location' => 'Choix du lieu',
        'family' => 'Choix d\'une famille',
        'physical' => 'Physique',
        'goals' => 'Objectifs',
        'traits' => 'Traits',
        'fears' => 'Craintes',
        'mannerisms' => 'Maniérismes',
        'history' => 'Histoire',
        'image' => 'Image',
        'free' => 'Texte libre',
    ],
    'hints' => [
        'is_personality_visible' => 'Tu peux cacher toute la personnalité des membres de type \'Observateur\'.',
    ],
    'sections' => [
        'general' => 'Inpourmation générale',
        'appearance' => 'Physique',
        'personality' => 'Personnalité',
        'history' => 'Histoire',
    ],
    'organisations' => [
        'create' => [
            'title' => 'Nouvelle Organisation pour :name',
            'description' => 'Associater une organisation à une personne',
            'success' => 'Personne ajoutée à l\'organisation.',
        ],
        'actions' => [
            'add' => 'Nouvelle organisation',
        ],
        'edit' => [
            'title' => 'Modifier l\'Organisation pour :name',
            'description' => '',
            'success' => 'Organisation de personne modifiée.',
        ],
        'fields' => [
            'organisation' => 'Organisation',
            'role' =>  'Rôle',
        ],
        'placeholders' => [
            'organisation' => 'Choix d\'une organisation...',
        ],
        'destroy' => [
            'success' => 'Organisation de personne supprimée.',
        ]
    ],
    'attributs' => [
        'create' => [
            'title' => 'Nouveau Attribut pour :name',
            'description' => 'Défini un attribut pour une personne',
            'success' => 'Attribut ajouté pour :name.',
        ],
        'actions' => [
            'add' => 'Ajouter un attribut',
        ],
        'edit' => [
            'title' => 'Modifier attribut pour :name',
            'description' => '',
            'success' => 'Attribut pour :name modifié.',
        ],
        'fields' => [
            'attribut' => 'Attribut',
            'value' =>  'Valeur',
        ],
        'placeholders' => [
            'attribut' => 'Nombre de bataille gagnée, date de marriage, initiative',
            'value' => 'Valeur'
        ],
        'destroy' => [
            'success' => 'Attribut pour :name supprimé.',
        ]
    ],
];
