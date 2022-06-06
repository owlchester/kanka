<?php

return [
    'helpers'   => [
        'main'  => 'Les campagnes publiques sont visibles par tous les utilisateurs qui ont un lien vers celle-ci ou par la page :public-campaigns. Les autorisations accordées aux utilisateurs qui consultent la campagne de cette manière sont contrôlées par le rôle :public-role de la campagne.',
    ],
    'title'     => 'Changer la visibilité de la campagne',
    'update'    => [
        'private'   => 'La campagne est dorénavant privée, et seuls ses membres y ont accès.',
        'public'    => 'La campagne est dorénavant publique. Ce changement peut prendre un peu de temps pour apparaître dans les :public-campaigns.',
    ],
];
