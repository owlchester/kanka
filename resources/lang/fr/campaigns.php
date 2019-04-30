<?php

return [
    'create'                            => [
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
    'destroy'                           => [
        'success'   => 'Campagne supprimée.',
    ],
    'edit'                              => [
        'description'   => 'Modifier la campagne',
        'success'       => 'Campagne modifiée.',
        'title'         => 'Modifier la campagne :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'Les nouveaux personnages ont leur personnalité privée par défault.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nouvelles entités privées',
    ],
    'errors'                            => [
        'access'        => 'Accès refusé pour cette campagne.',
        'unknown_id'    => 'Campagne inconnue.',
    ],
    'export'                            => [
        'description'   => 'Exporter la campagne.',
        'errors'        => [
            'limit' => 'Nombre d\'export maximal par jour excédé pour cette campagne.',
        ],
        'helper'        => 'Export de la campagne. Une notification content un lien de téléchargement sera généré.',
        'success'       => 'L\'export de la campagne est en préparation. Une notification dans Kanka avec un lien de téléchargement sera généré dès que c\'est prêt.',
        'title'         => 'Export Campagne :name',
    ],
    'fields'                            => [
        'description'                   => 'Description',
        'entity_count'                  => 'Nombre d\'entités',
        'entity_personality_visibility' => 'Visibilité des traits de personnages',
        'entity_visibility'             => 'Visibilité d\'entité',
        'header_image'                  => 'Image de fond pour le tableau de bord',
        'image'                         => 'Image',
        'locale'                        => 'Langue',
        'name'                          => 'Nom',
        'system'                        => 'Système',
        'visibility'                    => 'Visibilité',
    ],
    'helpers'                           => [
        'entity_personality_visibility' => 'Lorsqu\'une nouvelle entité est créée, l\'option "Privé" sera automatiquement sélectionnée.',
        'entity_visibility'             => 'Lorsqu\'une nouvelle entité est créée, l\'option "Privé" sera automatiquement sélectionnée.',
        'locale'                        => 'La langue dans laquelle la campagne est écrite. Ceci est utilisé pour générer du contenu ainsi que pour grouper les campagnes publiques.',
        'name'                          => 'Le nom de la campagne doit contenir au minimum 4 caractère.',
        'system'                        => 'Si la campagne est publiquement visible, elle sera affichée dans la page :link.',
        'visibility'                    => 'Une campagne public peut être vue par toute personne ayant un lien vers celle-ci.',
    ],
    'index'                             => [
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
    'invites'                           => [
        'actions'       => [
            'add'   => 'Inviter',
            'link'  => 'Nouveau Lien',
        ],
        'create'        => [
            'button'        => 'Inviter',
            'description'   => 'Invite tes amis à ta campagne',
            'link'          => 'Lien créé: <a href=":url" target="_blank">:url</a>',
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
            'type'      => 'Type',
            'validity'  => 'Validité',
        ],
        'helpers'       => [
            'validity'  => 'Nombre de fois que le lie peut être utilisé avant d\'être désactivé.',
        ],
        'placeholders'  => [
            'email' => 'L\'adresse email de ton ami',
        ],
        'types'         => [
            'email' => 'Email',
            'link'  => 'Lien',
        ],
    ],
    'leave'                             => [
        'confirm'   => 'Est-tu sûr de vouloir quitter :name? Tu n\'aura plus accès aux données, sauf si un Proprio de la campagne t\'invites à nouveau.',
        'error'     => 'Impossible de quitter la campagne.',
        'success'   => 'Tu as quitté la campagne.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Basculer',
            'switch-back'   => 'Retour à mon compte',
        ],
        'create'                => [
            'title' => 'Ajouter un membre à la campagne',
        ],
        'description'           => 'Gestion des membres de la campagne',
        'edit'                  => [
            'description'   => 'Modifier un membre de la campagne',
            'title'         => 'Modifier membre :name',
        ],
        'fields'                => [
            'joined'    => 'Rejoint',
            'name'      => 'Utilisateur',
            'role'      => 'Rôle',
            'roles'     => 'Rôles',
        ],
        'help'                  => 'Il n\'y a pas de limite sur le nombre de membre dans une campagne. En tant qu\'Admin d\'une campagne, tu peux retirer un membre qui n\'est plus actif à tout moment.',
        'helpers'               => [
            'switch'    => 'Basculer vers cet utilisateur',
        ],
        'impersonating'         => [
            'message'   => 'Tu visualises la campagne en tant qu\'un autre utilisateur. Certaines fonctionalités ont été désactivées, mais le reste réagit exactement tel que l\'utilisateur le verrait. Tu peux revenir à ton utilisateur en cliquant sur le bouton "Retour à mon compte" situé à l\'emplacement du bouton de déconnexion.',
            'title'     => 'Se faisant passer pour :name',
        ],
        'invite'                => [
            'description'   => 'Invite tes amis à la campagne en fournissant une adresse email. Dès qu\'ils acceptent ton invitation, ils seront ajouté à la campagne. Tu peux annuler une invitation à tout moment.',
            'more'          => 'Tu peux ajouter plus de rôle sur la :link.',
            'roles_page'    => 'page des rôles',
            'title'         => 'Invitation',
        ],
        'roles'                 => [
            'member'    => 'Membre',
            'owner'     => 'Administrateur',
            'player'    => 'Joueur',
            'public'    => 'Publique',
            'viewer'    => 'Observateur',
        ],
        'switch_back_success'   => 'Tu es de retour à ton compte.',
        'title'                 => 'Membres de la campagne :name',
        'your_role'             => 'Rôle: \'<i>:rôle</i>\'',
    ],
    'panels'                            => [
        'permission'    => 'Permission',
        'sharing'       => 'Partage',
    ],
    'placeholders'                      => [
        'description'   => 'Une petite description de la campagne',
        'locale'        => 'La langue utilisée',
        'name'          => 'Le nom de la campagne',
        'system'        => 'D&D 5e, 3.5, Pathfinder, Tigres Volants, Grups',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Ajouter un rôle',
        ],
        'create'        => [
            'success'   => 'Rôle créé.',
            'title'     => 'Créer un nouveau rôle pour :name',
        ],
        'description'   => 'Gestion des membres de la campagne',
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
            'type'          => 'Type',
            'users'         => 'Utilisateurs',
        ],
        'helper'        => [
            '1' => 'Une campagne peut avoir autant de rôle que désiré. Le rôle "Admin" a automatiquement accès à tout dans une campagne, et chaque autre rôle peut être configuré pour avoir des accès spécifiques à divers entités (personnages, lieux, etc).',
            '2' => 'Les entités individuelles peuvent avoir leurs propres permissions sous l\'onglet "Permissions" de celles-ci. Cet onglet apparait dès le moment qu\'une campagne à plusieurs membres ou rôles.',
            '3' => 'Il y a deux options possibles. Soit le mode "opt-out", ou les rôles ont le droit de lire toutes les entités, couplé à l\'option "Privé" sur les entités pour les cacher. Sinon, il est possible de ne pas donner de droits généraux aux rôles, et à la place donner des rôles individuellement sur les entités pour les rendre visibles.',
        ],
        'hints'         => [
            'public'            => 'Si la campagne est en mode publique, ce rôle est utilisé pour les visiteurs qui ne font pas partie de la campagne. :more',
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
        'title'         => 'Rôles de la campagne :name',
        'types'         => [
            'owner'     => 'Propriétaire',
            'public'    => 'Publique',
            'standard'  => 'Standard',
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
    'settings'                          => [
        'description'   => 'Activer ou désactiver des modules de la campagne.',
        'edit'          => [
            'success'   => 'Campagne modifiée.',
        ],
        'helper'        => 'Tu peux facilement modifier les éléments disponnibles pour la campagne. Les éléments déjà créés seront simplement cachés',
        'helpers'       => [
            'calendars'     => 'Un endroit pour définir les calendriers de ton monde.',
            'characters'    => 'Les peuples de ton monde.',
            'conversations' => 'Conversations fictives entre des personnages ou entre membres de la campagne.',
            'dice_rolls'    => 'Pour ceux qui utilisent Kanka pour une campagne JdR, un système pour des jets de dés.',
            'events'        => 'Jours fériers, festivaux, désastres, anniversaires, guerres.',
            'families'      => 'Clans ou familles, leurs relations et leur membres.',
            'items'         => 'Armes, véhicules, artéfacts, objets légendaires.',
            'journals'      => 'Observations écritent par des personnages, ou préparation de session pour le maître de jeu.',
            'locations'     => 'Planetes, plaines, continents, rivières, pays, temples, tavernes.',
            'menu_links'    => 'Liens personnalisés dans la navigation.',
            'notes'         => 'Histoires, légendes, religions, magies, races.',
            'organisations' => 'Cultes, unités militaires, factions, guildes.',
            'quests'        => 'Gestionnaire de quêtes avec personnages et lieux.',
            'races'         => 'Si la campagne a plus d\'une race, ce module permet de facilement organiser celles-ci.',
            'tags'          => 'Chaque entité peut avoir plusieurs étiquettes. Les étiquettes peuvent appartenir à d\'autres étiquettes.',
        ],
        'title'         => 'Modules de la campagne :name',
    ],
    'show'                              => [
        'actions'       => [
            'leave' => 'Quitter la campagne',
        ],
        'description'   => 'Détail d\'une campagne',
        'tabs'          => [
            'export'        => 'Export',
            'information'   => 'Information',
            'members'       => 'Membres',
            'menu'          => 'Menu',
            'roles'         => 'Rôles',
            'settings'      => 'Modules',
        ],
        'title'         => 'Campagne :name',
    ],
    'visibilities'                      => [
        'private'   => 'Privé',
        'public'    => 'Publique',
        'review'    => 'En attente de revue',
    ],
];
