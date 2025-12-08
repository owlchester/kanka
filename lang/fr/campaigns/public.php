<?php

return [
    'helpers'   => [
        'main'          => 'Les campagnes publiques sont visibles par tous les utilisateurs qui ont un lien vers celle-ci ou par la page :public-campaigns. Les autorisations accordées aux utilisateurs qui consultent la campagne de cette manière sont contrôlées par le rôle :public-role de la campagne.',
        'new'           => 'Rends-la publique pour que la communauté puisse la découvrir, ou garde-la privée pour les membres invités uniquement.',
        'permissions'   => 'Rendre ta campagne publique ne partage pas automatiquement le contenu. Configure ce que les visiteurs publics peuvent voir dans les réglages du rôle :public.',
    ],
    'title'     => 'Changer la visibilité de la campagne',
    'update'    => [
        'private'   => 'La campagne est dorénavant privée, et seuls ses membres y ont accès.',
        'public'    => 'La campagne est dorénavant publique. Ce changement peut prendre un peu de temps pour apparaître dans les :public-campaigns.',
        'unlisted'  => 'La campagne n\'est plus répertoriée. Toute personne avec le lien peut y accéder, mais elle n\'apparaît pas sur la page :public-campaigns.',
    ],
];
