<?php

return [
    'actions'       => [
        'add'   => 'Ajouter un lien',
    ],
    'create'        => [
        'success'   => 'Lien :name ajouté à :entity.',
        'title'     => 'Ajouter un lien à :name',
    ],
    'destroy'       => [
        'success'   => 'Lien :name retiré de :entity.',
    ],
    'fields'        => [
        'icon'      => 'Icone',
        'name'      => 'Nom',
        'position'  => 'Position',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'Aller à :name',
        'icon'      => 'Personaliser l\'icône affichée pour le lien. Utiliser les options de :fontawesome ou laisser le champ vide.',
        'leaving'   => 'Tu es sur le point de naviguer hors de Kanka et vers un autre domaine. La page où tu vas a été définie par un utilisateur et n\'est pas vérifié par Kanka.',
        'url'       => 'L\'URL de destination est :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Les campagnes boostées peuvent définir des liens sur les entités.',
        'title'     => 'Liens pour :name',
    ],
    'unboosted'     => [
        'text'  => 'Ajouter des liens vers des resources externes qui sont directement visible sur l\'entité est réservé aux :boosted-campaigns.',
        'title' => 'Fonctionnalité de campagne boostée',
    ],
    'update'        => [
        'success'   => 'Lien :name modifié pour :entity.',
        'title'     => 'Modifier le lien pour :name',
    ],
];
