<?php

return [
    'actions'           => [
        'add'   => 'Ajouter un lien',
    ],
    'call-to-action'    => 'Ajoutes des liens vers des ressources externes sur cette entité, comme DnDBeyond, et ils s\'afficheront directement sur la vue d\'ensemble de l\'entité.',
    'create'            => [
        'helper'    => 'Ajouter un lien externe vers :name, par exemple vers sa page DnDBeyond.',
        'success'   => 'Lien :name ajouté à :entity.',
        'title'     => 'Ajouter un lien à :name',
    ],
    'destroy'           => [
        'success'   => 'Lien :name retiré de :entity.',
    ],
    'fields'            => [
        'icon'      => 'Icone',
        'name'      => 'Nom',
        'position'  => 'Position',
        'url'       => 'URL',
    ],
    'go'                => [
        'actions'       => [
            'confirm'   => 'Je suis sûr',
            'trust'     => 'Ne plus me demander',
        ],
        'description'   => 'Ce lien te redirige vers :link. Es-tu sûr de vouloir y aller?',
        'title'         => 'Départ de Kanka',
    ],
    'helpers'           => [
        'icon'      => 'Personaliser l\'icône affichée pour le favori. Utiliser les options de :fontawesome ou laisser le champ vide.',
        'parent'    => 'Afficher ce favori après un élément de la navigation, au lieu de l\'afficher dans la section des favoris.',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Les campagnes boostées peuvent définir des liens sur les entités.',
        'title'     => 'Liens pour :name',
    ],
    'unboosted'         => [],
    'update'            => [
        'success'   => 'Lien :name modifié pour :entity.',
        'title'     => 'Modifier le lien pour :name',
    ],
];
