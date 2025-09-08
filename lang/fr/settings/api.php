<?php

return [
    'applications'      => [
        'title' => 'Applications authorisées',
    ],
    'clients'           => [
        'empty' => 'Aucun client OAuth n\'a été créé.',
        'form'  => [
            'name'                  => 'Nom du client',
            'name_helper'           => 'Quelque chose que tes utilisateurs reconnaîtront et en qui ils auront confiance.',
            'name_placeholder'      => 'Nom du client',
            'redirect'              => 'URL de redirection',
            'redirect_helper'       => 'L\'URL de rappel d\'autorisation de ton application.',
            'redirect_placeholder'  => 'http://ma-superbe-app.info/callback',
        ],
        'new'   => 'Nouveau client',
        'title' => 'Clients OAuth',
        'update'=> 'Modifier le client',
    ],
    'fields'            => [
        'client'        => 'ID du client',
        'client_name'   => 'Nom du client',
        'scopes'        => 'Scopes',
        'secret'        => 'Secret',
        'token_name'    => 'Nom du jeton',
    ],
    'new'               => [
        'copy'      => 'Jeton d\'accès copié au presse-papier',
        'helper'    => 'Ton nouveau jeton d\'accès personnel:',
        'title'     => 'Ton nouveau jeton d\'accès personnel:',
    ],
    'revoke'            => 'Révoker',
    'revoke-confirm'    => 'Confirmer la révocation',
    'tokens'            => [
        'empty' => 'Tu n\'as pas encore créé de jeton d\'accès.',
        'form'  => [
            'name'              => 'Nom du jeton',
            'name_placeholder'  => 'Nom du jeton',
        ],
        'new'   => 'Créer le jeton',
        'title' => 'Jetons d\'accès personnels',
    ],
];
