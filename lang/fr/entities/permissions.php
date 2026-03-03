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
    'toggle'    => [
        'label'     => 'Confidentialité de l\'entrée',
        'private'   => [
            'description'   => 'Seulement visible aux membres du rôle :admin.',
            'title'         => 'Privé',
        ],
        'public'    => [
            'description'   => 'Visibles aux rôles et membres suivants.',
            'title'         => 'Publique',
        ],
    ],
];
