<?php

return [
    'index' => [
        'title' => 'Campagnes',
        'description' => 'Gère tes campagnes.',
        'add' => 'Nouvelle Campagne',
        'select' => 'Choisi une campagne',
        'list' => 'Tes campagnes',
        'actions' => [
            'new' => [
                'title' => 'Nouvelle Campagne',
                'description' => 'Créer une nouvelle campagne',
            ]
        ]
    ],
    'create' => [
        'title' => 'Créer une nouvelle campagne',
        'description' => '',
        'success' => 'Campagne créée.',
        'success_first_time' => 'La première campagne a été créée! Quelques éléments ont été créé pour aider à bien démarrer.',

        'helper' => [
            'title' => 'Bienvenue à :name!',
            'first' => 'Merci pour l\'intérêt! Avant de pouvoir avancer, nous n\'avons que besoin d\'un <b>nom de campagne</b>. Ceci est le nom unique du monde qui le distingue des autres. Pas d\'inquiétude pour l\'originalité, le nom peut être changé à tout moment, autant de fois que désiré, et d\'autres campagnes peuvent être créées.',
            'second' => 'Bref! Alors, ce nom?',
        ]
    ],
    'show' => [
        'title' => 'Campagne :name',
        'description' => 'Détail d\'une campagne',
        'actions' => [
            'leave' => 'Quitter la campagne',
        ],
        'tabs' => [
            'information' => 'Information',
            'members' => 'Membres',
            'settings' => 'Paramètres',
        ],
    ],
    'edit' => [
        'title' => 'Modifier la campagne :campagne',
        'description' => '',
        'success' => 'Campagne modifiée.',
    ],
    'destroy' => [
        'success' => 'Campagne supprimée.',
    ],
    'fields' => [
        'name' => 'Nom',
        'image' => 'Image',
        'locale' => 'Langue',
        'description' => 'Description',
    ],
    'placeholders' => [
        'name' => 'Le nom de la campagne',
        'locale' => 'La langue utilisée',
        'description' => 'Une petite description de la campagne',
    ],
    'members' => [
        'create' => [
            'title' => 'Ajouter un membre à la campagne',
        ],
        'invite' => [
            'title' => 'Invitation',
            'description' => 'Invite tes amis à la campagne en fournissant une adresse email. Dès qu\'ils ' .
            'acceptent ton invitation, ils seront ajouté en tant que \'Observateur\'. Tu peux annuler une invitation à ' .
            'tout moment.',
        ],
        'edit' => [
            'title' => 'Modifier membre :name',
            'description' => '',
        ],
        'fields' => [
            'name' => 'Utilisateur',
            'role' => 'Rôle',
            'joined' => 'Rejoint',
        ],
        'your_role' => 'Rôle: \'<i>:role</i>\'',
        'roles' => [
            'owner' => 'Administrateur',
            'member' => 'Membre',
            'viewer' => 'Observateur',
        ]
    ],
    'invites' => [
        'fields' => [
            'email' => 'Email',
            'created' => 'Envoyé',
        ],
        'placeholders' => [
            'email' => 'L\'adresse email de ton ami',
        ],
        'actions' => [
            'add' => 'Inviter',
        ],
        'create' => [
            'success' => 'Invitation envoyée.',
            'title' => 'Invite un ami à la campagne',
            'description' => '',
            'button' => 'Inviter',
        ],
        'destroy' => [
            'success' => 'Invitation annulée.',
        ],
        'email' => [
            'title' => 'Invitation de :name',
            'subject' => ':name t\'as invité à rejoindre la campagne \':campagne\' on kanka.io! ' .
                'Utilises ce lien pour accepter son invitation.',
            'link' => '<a href=":link">Joindre la campagne de :name</a>'
        ],
        'error' => [
            'invalid_token' => 'Ce code d\'activation n\'est plus valide.',
            'inactive_token' => 'Ce code d\'activation a déjà été utilisé, ou la campagne n\'existe plus.',
            'login' => 'Connectes toi ou créé un compte pour joindre la campagne.',
            'already_member' => 'Tu es déjà un membre de cette campagne.'
        ]
    ],
    'settings' => [
        'helper' => 'Tu peux facilement modifier les éléments disponnibles pour la campagne. Les éléments déjà créés ' .
            'seront simplement cachés',
        'fields' => [
            'characters' => 'Personnages',
            'events' => 'Evénements',
            'families' => 'Familles',
            'items' => 'Objets',
            'journals' => 'Journaux',
            'locations' => 'Lieux',
            'notes' => 'Notes',
            'organisations' => 'Organisations',
            'quests' => 'Quêtes',
        ],
        'edit' => [
            'success' => 'Campagne modifiée.',
        ],
    ],
    'leave' => [
        'confirm' => 'Est-tu sûr de vouloir quitter :name? Tu n\'aura plus accès aux données, ' .
            'sauf si un Proprio de la campagne t\'invites à nouveau.',
        'success' => 'Tu as quitté la campagne.',
        'error' => 'Impossible de quitter la campagne.'
    ]
];
