<?php

return [
    'fields'    => [
        'character_personality_visibility'  => 'Visibilité par défaut de la personnalité des personnages',
        'connections'                       => 'Vue des connexions d\'entrée',
        'connections_mode'                  => 'Style de la carte des connexions',
        'descendants'                       => 'Filtrage par défaut des sous-listes',
        'entity_privacy'                    => 'Visibilité des nouvelles entrées',
        'gallery_visibility'                => 'Visibilité par défaut des images de la galerie',
        'post_collapsed'                    => 'Mise en page des nouveaux articles',
        'private_mention_visibility'        => 'Mentions d\'entrées privées',
        'related_visibility'                => 'Visibilité du contenu lié',
    ],
    'helpers'   => [
        'character_visibility'          => 'Définit la visibilité des traits de personnalité quand tu crées des personnages',
        'connections'                   => 'Choisis si les pages de connexions d\'entrées affichent par défaut une carte visuelle ou une liste',
        'connections_mode'              => 'Définit le style de mise en page par défaut des cartes de connexions (premium)',
        'descendants'                   => 'Quand tu consultes les sous-listes d\'une entrée (comme les personnages d\'un lieu), choisis d\'afficher seulement les enfants directs ou tous les descendants',
        'display'                       => 'Définis les options d\'affichage par défaut des pages d\'entrée',
        'entity'                        => 'Contrôle la visibilité que Kanka applique automatiquement au nouveau contenu',
        'entity_privacy'                => 'Définit la visibilité des nouveaux personnages, lieux, etc',
        'gallery_visibility'            => 'Valeur de visibilité par défaut pour les images que tu ajoutes à la galerie',
        'post_collapsed'                => 'Quand tu crées des articles, définis s\'il est réduit ou développé',
        'privacy'                       => 'Définis les visibilités par défaut du nouveau contenu. Ces réglages s\'appliquent quand tu crées du contenu et peuvent être changés pour chaque élément',
        'private_mention_visibility'    => 'Quand tu mentionnes une entrée privée dans du contenu visible, choisis si son nom apparaît ou non',
        'related_visibility'            => 'Contrôle la visibilité des articles, propriétés et relations ajoutés aux entrées',
    ],
    'sections'  => [
        'display'   => 'Affichage par défaut des entrées',
        'entity'    => 'Valeurs par défaut des entrées',
        'media'     => 'Valeurs par défaut des médias',
        'mention'   => 'Comportement des mentions',
    ],
    'tutorial'  => 'Optimise la création de contenu avec des réglages par défaut malins. Choisis les visibilités par défaut pour les entrées, articles, images et autres contenus. Ces préférences s\'appliquent automatiquement quand tu crées du contenu, te faisant gagner du temps tout en gardant ta campagne organisée',
    'update'    => [
        'success'   => 'Valeurs par défaut de la campagne mises à jour',
    ],
    'values'    => [
        'collapsed'     => [
            'collapsed' => 'Réduit',
            'default'   => 'Par défaut',
            'expanded'  => 'Développé',
        ],
        'connections'   => [
            'explorer'  => 'Carte des connexions (premium)',
            'list'      => 'Interface en liste',
        ],
        'descendants'   => [
            'all'       => 'Afficher tous les descendants par défaut',
            'direct'    => 'Afficher les descendants directs par défaut',
        ],
        'mentions'      => [
            'private'   => 'Masquer le nom de la cible',
            'visible'   => 'Afficher le nom de la cible',
        ],
    ],
];
