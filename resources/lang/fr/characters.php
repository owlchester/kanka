<?php

return [
    'attributes'    => [
        'actions'       => [
            'add'   => 'Ajouter un attribut',
        ],
        'create'        => [
            'description'   => 'Défini un attribut pour une personne',
            'success'       => 'Attribut ajouté pour :name.',
            'title'         => 'Nouveau Attribut pour :name',
        ],
        'destroy'       => [
            'success'   => 'Attribut pour :name supprimé.',
        ],
        'edit'          => [
            'description'   => '',
            'success'       => 'Attribut pour :name modifié.',
            'title'         => 'Modifier attribut pour :name',
        ],
        'fields'        => [
            'attribute' => 'Attribut',
            'value'     => 'Valeur',
        ],
        'placeholders'  => [
            'attribute' => 'Nombre de bataille gagnée, date de marriage, initiative',
            'value'     => 'Valeur',
        ],
    ],
    'create'        => [
        'description'   => '',
        'success'       => 'Personne \':name\' créée.',
        'title'         => 'Créer une nouvelle personne',
    ],
    'destroy'       => [
        'success'   => 'Personne \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Personne \':name\' modifiée.',
        'title'         => 'Modifier Personne :name',
    ],
    'fields'        => [
        'age'                       => 'Age',
        'eye'                       => 'Couleur des yeux',
        'family'                    => 'Famille',
        'fears'                     => 'Craine',
        'free'                      => 'Texte libre',
        'goals'                     => 'Objectifs',
        'hair'                      => 'Cheveux',
        'height'                    => 'Taille',
        'history'                   => 'Histoire',
        'image'                     => 'Image',
        'is_personality_visible'    => 'Personnalité visible',
        'languages'                 => 'Langues',
        'location'                  => 'Lieu',
        'mannerisms'                => 'Maniérismes',
        'name'                      => 'Nom',
        'physical'                  => 'Physique',
        'race'                      => 'Race',
        'relation'                  => 'Relation',
        'sex'                       => 'Sexe',
        'skin'                      => 'Peau',
        'title'                     => 'Titre',
        'traits'                    => 'Traits',
        'weight'                    => 'Poid',
    ],
    'hints'         => [
        'is_personality_visible'    => 'Tu peux cacher toute la personnalité des membres de type \'Observateur\'.',
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
    'organisations' => [
        'actions'       => [
            'add'   => 'Nouvelle organisation',
        ],
        'create'        => [
            'description'   => 'Associater une organisation à une personne',
            'success'       => 'Personne ajoutée à l\'organisation.',
            'title'         => 'Nouvelle Organisation pour :name',
        ],
        'destroy'       => [
            'success'   => 'Organisation de personne supprimée.',
        ],
        'edit'          => [
            'description'   => '',
            'success'       => 'Organisation de personne modifiée.',
            'title'         => 'Modifier l\'Organisation pour :name',
        ],
        'fields'        => [
            'organisation'  => 'Organisation',
            'role'          => 'Rôle',
        ],
        'placeholders'  => [
            'organisation'  => 'Choix d\'une organisation...',
        ],
    ],
    'placeholders'  => [
        'age'       => 'Age',
        'eye'       => 'Couleur des yeux',
        'family'    => 'Choix d\'une famille',
        'fears'     => 'Craintes',
        'free'      => 'Texte libre',
        'goals'     => 'Objectifs',
        'hair'      => 'Cheveux',
        'height'    => 'Taille',
        'history'   => 'Histoire',
        'image'     => 'Image',
        'languages' => 'Langues',
        'location'  => 'Choix du lieu',
        'mannerisms'=> 'Maniérismes',
        'name'      => 'Nom',
        'physical'  => 'Physique',
        'race'      => 'Race',
        'sex'       => 'Sexe',
        'skin'      => 'Peau',
        'title'     => 'Titre',
        'traits'    => 'Traits',
        'weight'    => 'Poid',
    ],
    'sections'      => [
        'appearance'    => 'Physique',
        'general'       => 'Inpourmation générale',
        'history'       => 'Histoire',
        'personality'   => 'Personnalité',
    ],
    'show'          => [
        'description'   => 'Détail d\'une personne',
        'tabs'          => [
            'attributes'    => 'Attributs',
            'free'          => 'Texte libre',
            'history'       => 'Histoire',
            'organisations' => 'Organisations',
            'personality'   => 'Personnalité',
            'relations'     => 'Relations',
        ],
        'title'         => 'Personne :name',
    ],
];
