<?php

return [
    'create'        => [
        'description'           => 'Créer une nouvelle campagne',
        'helper'                => [
            'first' => 'Merci pour l\'intérêt! Avant de pouvoir avancer, nous n\'avons que besoin d\'un <b>nom de campagne</b>. Ceci est le nom unique du monde qui le distingue des autres. Pas d\'inquiétude pour l\'originalité, le nom peut être changé à tout moment, autant de fois que désiré, et d\'autres campagnes peuvent être créées.',
            'second'=> 'Bref! Alors, ce nom?',
            'title' => 'Bienvenue à :name!',
        ],
        'success'               => 'Campagne créée.',
        'success_first_time'    => 'La première campagne a été créée! Quelques éléments ont été créé pour aider à bien démarrer.',
        'title'                 => 'Nouvelle Campagne',
    ],
    'destroy'       => [
        'success'   => 'Campagne supprimée.',
    ],
    'edit'          => [
        'description'   => 'Modifier la campagne',
        'success'       => 'Campagne modifiée.',
        'title'         => 'Modifier la campagne :campaign',
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
            'description'   => 'Invite tes amis à ta campagne',
            'success'       => 'Invitation envoyée.',
            'title'         => 'Invite un ami à la campagne',
        ],
        'destroy'       => [
            'success'   => 'Invitation annulée.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Joindre la campagne de :name</a>',
            'subject'   => ':name t\'as invité à rejoindre la campagne \':campagne\' on kanka.io! Utilises ce lien pour accepter leur invitation.',
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
            'role'      => 'Rôle',
        ],
        'placeholders'  => [
            'email' => 'L\'adresse email de ton ami',
        ],
    ],
    'leave'         => [
        'confirm'   => 'Est-tu sûr de vouloir quitter :name? Tu n\'aura plus accès aux données, sauf si un Proprio de la campagne t\'invites à nouveau.',
        'error'     => 'Impossible de quitter la campagne.',
        'success'   => 'Tu as quitté la campagne.',
    ],
    'members'       => [
        'create'    => [
            'title' => 'Ajouter un membre à la campagne',
        ],
        'edit'      => [
            'description'   => 'Modifier un membre de la campagne',
            'title'         => 'Modifier membre :name',
        ],
        'fields'    => [
            'joined'    => 'Rejoint',
            'name'      => 'Utilisateur',
            'role'      => 'Rôle',
            'roles'     => 'Rôles',
        ],
        'help'      => 'Il n\'y a pas de limite sur le nombre de membre dans une campagne. En tant qu\'Admin d\'une campagne, tu peux retirer un membre qui n\'est plus actif à tout moment.',
        'invite'    => [
            'description'   => 'Invite tes amis à la campagne en fournissant une adresse email. Dès qu\'ils acceptent ton invitation, ils seront ajouté à la campagne. Tu peux annuler une invitation à tout moment.',
            'title'         => 'Invitation',
        ],
        'roles'     => [
            'member'    => 'Membre',
            'owner'     => 'Administrateur',
            'viewer'    => 'Observateur',
        ],
        'your_role' => 'Rôle: \'<i>:rôle</i>\'',
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
        'helper'        => [
            '1' => 'Une campagne peut avoir autant de rôle que désiré. Le rôle "Admin" a automatiquement accès à tout dans une campagne, et chaque autre rôle peut être configuré pour avoir des accès spécifiques à divers entités (personnages, lieux, etc).',
            '2' => 'Les entités individuelles peuvent avoir leurs propres permissions sous l\'onglet "Permissions" de celles-ci. Cet onglet apparait dès le moment qu\'une campagne à plusieurs membres ou rôles.',
            '3' => 'Il y a deux options possibles. Soit le mode "opt-out", ou les rôles ont le droit de lire toutes les entités, couplé à l\'option "Privé" sur les entités pour les cacher. Sinon, il est possible de ne pas donner de droits généraux aux rôles, et à la place donner des rôles individuellement sur les entités pour les rendre visibles.',
        ],
        'hints'         => [
            'role_permissions'  => 'Permettre au rôle \':name\' les actions suivantes sur toutes les entités.',
        ],
        'members'       => 'Membres',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Créer',
                'delete'        => 'Supprimer',
                'edit'          => 'Modifier',
                'permission'    => 'Gérer les permissions',
                'read'          => 'Voir',
            ],
            'hint'      => 'Ce rôle a automatiquement accès à tout.',
        ],
        'placeholders'  => [
            'name'  => 'Nom du rôle',
        ],
        'show'          => [
            'description'   => 'Membres et Permissions d\'un rôle de campagne',
            'title'         => 'Rôles de campagne',
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
            'settings'      => 'Modules',
        ],
        'title'         => 'Campagne :name',
    ],
];
