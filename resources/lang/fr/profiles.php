<?php

return [
    'avatar'        => [
        'success'   => 'Photo de profil modifiée.',
    ],
    'description'   => 'Modification du profil',
    'edit'          => [
        'success'   => 'Profil modifié',
    ],
    'editors'       => [
        'legacy'        => 'Ancien (TinyMCE 4)',
        'summernote'    => 'Summernote',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'hide_subscription'         => 'Cacher mon nom du :hall_of_fame.',
        'last_login_share'          => 'Partager la date de ma dernière connexion avec les autres membres de la campagne.',
        'name'                      => 'Nom',
        'new_password'              => 'Nouveau mot de passe',
        'new_password_confirmation' => 'Confirmation du nouveau mot de passe',
        'newsletter'                => 'Je souhaite être contacté par email de temps en temps.',
        'password'                  => 'Mot de passe actuel',
        'settings'                  => 'Paramètres',
        'theme'                     => 'Thème',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Vote Communautaire',
            'news'              => 'News',
        ],
        'settings'  => [
            'news'          => 'News - être notifié lors de nouvelles :news.',
            'newsletter'    => 'Newsletter - recevoir la newsletter Kanka.',
            'votes'         => 'Vote Communautaire - être notifié dès qu\'il y a un nouveau vote communautaire.',
        ],
        'title'     => 'Newsletter',
    ],
    'password'      => [
        'success'   => 'Mot de passe modifié.',
    ],
    'placeholders'  => [
        'email'                     => 'Adresse email',
        'name'                      => 'Nom tel qu\'affiché',
        'new_password'              => 'Nouveau mot de passe',
        'new_password_confirmation' => 'Confirmation du nouveau mot de passe',
        'password'                  => 'Saisie du mot de passe actuel',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Supprimer mon compte',
            'title'     => 'Suppression du compte',
            'warning'   => 'Toutes les données relatives au compte seront supprimées. Êtes-vous certain?',
        ],
        'password'  => [
            'title' => 'Modification du mot de passe',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Mentions Avancées',
            'date_format'           => 'Format de date',
            'default_nested'        => 'Vue imbriquée par défaut',
            'editor'                => 'Editeur de texte',
            'new_entity_workflow'   => 'Workflow de nouvelle entité',
            'pagination'            => 'Pagination (éléments par page)',
        ],
        'helpers'   => [
            'editor_v2' => 'L\'ancien éditeur de text (TinyMCE) ne supporte pas les mentions sur mobile, ni certaines fonctionnalités tel que la galerie de campagne.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'Lorsque cette option est activée, les mentions s\'afficheront tout le temps comme [entity:123] lors de l\'édition d\'une entité.',
            'default_nested'        => 'Active cette option pour que les listes s\'affichent par défaut de manière imbriquée.',
            'new_entity_workflow'   => 'Lorsqu\'une entité est créée, le workflow par défaut est de naviguer à la liste des entités. Ce workflow peut être changé pour afficher la nouvelle entité.',
        ],
        'success'   => 'Paramètres modifiés.',
    ],
    'theme'         => [
        'success'   => 'Thème modifié.',
        'themes'    => [
            'dark'      => 'Sombre',
            'default'   => 'Défaut',
            'future'    => 'Futur',
            'midnight'  => 'Bleu Minuit',
        ],
    ],
    'title'         => 'Profil',
    'workflows'     => [
        'created'   => 'Afficher l\'entité créée',
        'default'   => 'Liste des entités',
    ],
];
