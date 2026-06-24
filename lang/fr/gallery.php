<?php

return [
    'actions'   => [
        'add_url'   => 'Ajouter depuis une URL',
        'change'    => 'Changer',
        'gallery'   => 'Depuis la galerie',
        'upload'    => 'Télécharger depuis l\'appareil',
        'url'       => 'Télécharger une image à partir d\'une URL',
        'url_hint'  => 'Coller un lien d\'image',
    ],
    'browse'    => [
        'folder_count'      => ':count images',
        'folder_count_one'  => '1 image',
        'layouts'           => [
            'large' => 'Grands aperçus',
            'small' => 'Petits aperçus',
        ],
        'search'            => [
            'no_results'    => 'Aucune image ne correspond à ":term"',
            'placeholder'   => 'Recherche d\'une image dans la galerie',
            'results'       => 'Résultats pour ":term"',
            'try_again'     => 'Essayez un autre terme',
        ],
        'title'             => 'Galerie',
        'unauthorized'      => 'Aucun de tes rôles n\'a l\'autorisation de "parcourir la galerie".',
    ],
    'cta'       => [
        'action'    => 'Débloquer plus d\'espace de stockage',
        'helper'    => 'Débloquer jusqu\'à :taille GiB d\'espace de stockage avec une :premium-campaign.',
        'title'     => 'Stockage plein',
    ],
    'delete'    => [
        'success'   => '[0] Aucun élément supprimé|[1] Un élément supprimé|{2,*} :count éléments supprimés',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'Nos serveurs n\'ont pas pu télécharger l\'image donnée.',
            'gallery_full_free'     => 'L\'espace de stockage de la galerie est plein. Activer les fonctions premium pour obtenir plus d\'espace de stockage.',
            'gallery_full_premium'  => 'L\'espace de stockage de la galerie est plein. Supprimer d\'abord les fichiers inutilisés.',
            'invalid_format'        => 'Le fichier n\'est pas un format de fichier valide.',
            'invalid_url'           => 'L\'URL fournie n\'a pas pû être décodée comme une image.',
            'too_big'               => 'Le fichier est trop lourd.',
            'unauthorized'          => 'Aucun de tes rôles n\'a l\'autorisation de "ajouter à la galerie".',
        ],
    ],
    'drop'      => [
        'active'    => 'Déposer pour télécharger',
        'hint'      => 'Cliquer ou glisser une image ici',
    ],
    'file'      => [
        'saved' => 'Sauvegardé',
    ],
    'filters'   => [
        'only_unused'   => 'Afficher uniquement les fichiers inutilisés',
        'sort'          => 'Ordonner',
    ],
    'move'      => [
        'success'   => '[0] Aucun élément déplacé|[1] Un élément déplacé|{2,*} :count éléments déplacés',
    ],
    'update'    => [
        'home'      => 'Dossier d\'accueil',
        'success'   => '[0] Aucun élément mise à jour|[1] Mise à jour d\'un élément|{2,*} :count éléments mis à jour',
    ],
];
