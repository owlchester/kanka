<?php

return [
    'create'        => [
        'description'           => '',
        'helper'                => [
            'first' => 'Merci pour l\'intérêt! Avant de pouvoir avancer, nous n\'avons que besoin d\'un <b>nom de campagne</b>. Ceci est le nom unique du monde qui le distingue des autres. Pas d\'inquiétude pour l\'originalité, le nom peut être changé à tout moment, autant de fois que désiré, et d\'autres campagnes peuvent être créées.',
            'second'=> 'Bref! Alors, ce nom?',
            'title' => 'Bienvenue à :name!',
        ],
        'success'               => 'Campagne créée.',
        'success_first_time'    => 'La première campagne a été créée! Quelques éléments ont été créé pour aider à bien démarrer.',
        'title'                 => 'Créer une nouvelle campagne',
    ],
    'destroy'       => [
        'success'   => 'Campagne supprimée.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Campagne modifiée.',
        'title'         => 'Modifier la campagne :campagne',
    ],
    'fields'        => [
        'description'   => 'Description',
        'image'         => 'Image',
        'locale'        => 'Langue',
        'name'          => 'Nom',
    ],
    'index'         => [
        'actions'       => [
            'new'   => [
                'description'   => 'Créer une nouvelle campagne',
                'title'         => 'Nouvelle Campagne',
            ],
        ],
        'add'           => 'Nouvelle Campagne',
        'description'   => 'Gère tes campagnes.',
        'list'          => 'Tes campagnes',
        'select'        => 'Choisi une campagne',
        'title'         => 'Campagnes',
    ],
    'invites'       => [
        'actions'       => [
            'add'   => 'Inviter',
        ],
        'create'        => [
            'button'        => 'Inviter',
            'description'   => '',
            'success'       => 'Invitation envoyée.',
            'title'         => 'Invite un ami à la campagne',
        ],
        'destroy'       => [
            'success'   => 'Invitation annulée.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Joindre la campagne de :name</a>',
            'subject'   => ':name t\'as invité à rejoindre la campagne \':campagne\' on kanka.io! Utilises ce lien pour accepter son invitation.',
            'title'     => 'Invitation de :name',
        ],
        'error'         => [
            'already_member'    => 'Tu es déjà un membre de cette campagne.',
            'inactive_token'    => 'Ce code d\'activation a déjà été utilisé, ou la campagne n\'existe plus.',
            'invalid_token'     => 'Ce code d\'activation n\'est plus valide.',
            'login'             => 'Connectes toi ou créé un compte pour joindre la campagne.',
        ],
        'fields'        => [
            'created'   => 'Envoyé',
            'email'     => 'Email',
        ],
        'placeholders'  => [
            'email' => 'L\'adresse email de ton ami',
        ],
    ],
    'leave'         => [
        'confirm'   => 'Est-tu sûr de vouloir quitter :name? Tu n\'aura plus accès aux données, sauf si un Admin de la campagne t\'invites à nouveau.',
        'error'     => 'Impossible de quitter la campagne.',
        'success'   => 'Tu as quitté la campagne.',
    ],
    'members'       => [
        'create'    => [
            'title' => 'Ajouter un membre à la campagne',
        ],
        'edit'      => [
            'description'   => '',
            'title'         => 'Modifier membre :name',
        ],
        'fields'    => [
            'joined'    => 'Rejoint',
            'name'      => 'Utilisateur',
            'role'      => 'Rôle',
        ],
        'invite'    => [
            'description'   => 'Invite tes amis à la campagne en fournissant une adresse email. Dès qu\'ils acceptent ton invitation, ils seront ajouté en tant que \'Observateur\'. Tu peux annuler une invitation à tout moment.',
            'title'         => 'Invitation',
        ],
        'roles'     => [
            'member'    => 'Membre',
            'owner'     => 'Administrateur',
            'viewer'    => 'Observateur',
        ],
        'your_role' => 'Rôle: \'<i>:role</i>\'',
    ],
    'placeholders'  => [
        'description'   => 'Une petite description de la campagne',
        'locale'        => 'La langue utilisée',
        'name'          => 'Le nom de la campagne',
    ],
    'roles'         => [
        'actions'       => [
            'add'   => 'Ajouter un rôle',
        ],
        'create'        => [
            'success'   => 'Rôle créé.',
            'title'     => 'Créer un nouveau rôle pour :name',
        ],
        'destroy'       => [
            'success'   => 'Rôle supprimé.',
        ],
        'edit'          => [
            'success'   => 'Rôle modifié.',
            'title'     => 'Modifier le rôle :name',
        ],
        'fields'        => [
            'name'          => 'Nom',
            'permissions'   => 'Permissions',
            'users'         => 'Utilisateurs',
        ],
        'members'       => 'Membres',
        'permissions'   => [
            'hint'  => 'Ce rôle a automatiquement accès à tout.',
        ],
        'placeholders'  => [
            'name'  => 'Nom du rôle',
        ],
        'show'          => [
            'description'   => '',
            'title'         => 'Rôle \':role\' de la campagne \':campaign\'',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Ajouter',
            ],
            'create'    => [
                'success'   => 'Utilisateur ajouté au rôle.',
                'title'     => 'Ajouter un utilisateur au rôle :name',
            ],
            'destroy'   => [
                'success'   => 'Utilisateur supprimé du rôle.',
            ],
            'fields'    => [
                'name'  => 'Nom',
            ],
        ],
    ],
    'settings'      => [
        'edit'      => [
            'success'   => 'Campagne modifiée.',
        ],
        'helper'    => 'Tu peux facilement modifier les éléments disponnibles pour la campagne. Les éléments déjà créés seront simplement cachés',
    ],
    'show'          => [
        'actions'       => [
            'leave' => 'Quitter la campagne',
        ],
        'description'   => 'Détail d\'une campagne',
        'tabs'          => [
            'information'   => 'Information',
            'members'       => 'Membres',
            'roles'         => 'Rôles',
            'settings'      => 'Paramètres',
        ],
        'title'         => 'Campagne :name',
    ],
];
