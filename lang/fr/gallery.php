<?php

return [
    'actions'   => [
        'gallery'   => 'Depuis la galerie',
        'url'       => 'Télécharger une image à partir d\'une URL',
    ],
    'browse'    => [
        'layouts'       => [
            'large' => 'Grands aperçus',
            'small' => 'Petits aperçus',
        ],
        'search'        => [
            'placeholder'   => 'Recherche d\'une image dans la galerie',
        ],
        'title'         => 'Galerie',
        'unauthorized'  => 'Aucun de tes rôles n\'a l\'autorisation de "parcourir la galerie".',
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
            'too_big'               => 'Le fichier est trop lourd.',
            'unauthorized'          => 'Aucun de tes rôles n\'a l\'autorisation de "ajouter à la galerie".',
        ],
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
