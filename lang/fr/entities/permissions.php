<?php

return [
    'quick' => [
        'empty-permissions' => 'Aucun rôle ou utilisateur hors des admins de la campagne n\'ont accès à cette entité.',
        'field'             => 'Modification rapide',
        'options'           => [
            'private'   => 'Privé pour tous sauf les admins',
            'visible'   => 'Visible pour les suivants',
        ],
        'private'           => 'Seulement les membres du rôle admin de la campagne ont actuellement accès à cette entité.',
        'public'            => 'L\'entité est actuellement visible à tous les utilisateurs et rôles ayant accès à celle-ci.',
        'success'           => [
            'private'   => 'L\'entité :entity est maintenant cachée.',
            'public'    => 'L\'entité :entity est maintenant visible.',
        ],
        'title'             => 'Permissions',
        'viewable-by'       => 'Visible par',
    ],
];
