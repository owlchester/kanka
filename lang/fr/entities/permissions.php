<?php

return [
    'privacy'   => [
        'text'      => 'Cette entrée est privée. Les permissions détaillées peuvent toujours être définies, mais tant que cette entrée est privée, ceux-ci seront ignorés, et seulement les membres du rôle :admin pourront voir cette entrée.',
        'warning'   => 'Attention',
    ],
    'quick'     => [
        'empty-permissions' => 'Aucun rôle ou utilisateur hors des admins de la campagne n\'ont accès à cette entrée.',
        'manage'            => 'Gérer les permissions',
        'screen-reader'     => 'Ouvrir les paramètres de sécurité',
        'success'           => [
            'private'   => 'L\'entrée :entity est maintenant cachée.',
            'public'    => 'L\'entrée :entity est maintenant visible.',
        ],
        'title'             => 'Permissions',
        'viewable-by'       => 'Visible par',
    ],
    'share'     => [
        'add_member'            => 'Accorder ou restreindre l’accès d’un membre…',
        'advanced'              => 'Permissions avancées',
        'custom'                => 'Personnalisé',
        'default'               => 'Par défaut (hérité)',
        'edit'                  => 'Peut modifier',
        'inherited_allow'       => 'Accès hérité: peut voir',
        'inherited_deny'        => 'Accès hérité: aucun accès',
        'members_empty'         => 'Aucun membre n’a d’accès personnalisé. Utilise le champ de recherche ci-dessus pour en ajouter un.',
        'members_title'         => 'Membres avec un accès personnalisé',
        'no_access'             => 'Aucun accès',
        'overridden_private'    => 'Ignoré tant que l’entrée est privée',
        'remove'                => 'Supprimer l’accès personnalisé',
        'roles_title'           => 'Rôles',
        'view'                  => 'Peut voir',
    ],
    'toggle'    => [
        'current'   => 'Actuel',
        'label'     => 'Confidentialité de l\'entrée',
        'private'   => [
            'description'   => 'Seulement visible aux membres du rôle :admin.',
            'title'         => 'Privé',
        ],
        'public'    => [
            'description'   => 'Visibles aux rôles et membres suivants.',
            'helper'        => 'Toute personne ayant accès à ce monde peut consulter cette entrée, selon les permissions de son rôle.',
            'title'         => 'Publique',
        ],
    ],
];
