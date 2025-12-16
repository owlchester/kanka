<?php

return [
    'privacy'   => [
        'text'      => 'Cette entité est privée. Les permissions détaillées peuvent toujours être définies, mais tant que cette entité est privée, ceux-ci seront ignorés, et seulement les membres du rôle :admin pourront voir cette entité.',
        'warning'   => 'Attention',
    ],
    'quick'     => [
        'empty-permissions' => 'Aucun rôle ou utilisateur hors des admins de la campagne n\'ont accès à cette entité.',
        'manage'            => 'Gérer les permissions',
        'screen-reader'     => 'Ouvrir les paramètres de sécurité',
        'success'           => [
            'private'   => 'L\'entité :entity est maintenant cachée.',
            'public'    => 'L\'entité :entity est maintenant visible.',
        ],
        'title'             => 'Permissions',
        'viewable-by'       => 'Visible par',
    ],
    'toggle'    => [
        'label'     => 'Confidentialité de l\'entité',
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
