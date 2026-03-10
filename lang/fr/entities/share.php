<?php

return [
    'buttons'   => [
        'copy'          => 'Copier le lien',
        'make_public'   => 'Rendre la campagne publique',
    ],
    'fields'    => [
        'campaign_access'   => 'Paramètres de campagne',
        'visibility_mode'   => 'Corriger la visibilité',
    ],
    'helpers'   => [
        'campaign_access'               => 'Pour partager ceci publiquement, la campagne elle-même doit d\'abord être rendue publique.',
        'entity_permissions_warning'    => 'Rendre cette campagne publique permet à tout le monde de la voir. Les entrées marquées comme privées restent cachées.',
        'hidden_explanation'            => 'La campagne est publique, mais cette entrée est actuellement cachée aux non-membres.',
        'hidden_unlisted_explanation'   => 'La campagne est non listée, seuls ceux qui ont le lien peuvent la trouver.',
        'member-link'                   => 'Partager uniquement avec les membres',
        'private_explanation'           => 'Seuls les membres peuvent accéder à cette entrée.',
        'public_explanation'            => 'La campagne et cette entrée sont publiques. N\'importe qui avec le lien peut la voir.',
        'unlisted_explanation'          => 'La campagne est non listée et cette entrée est visible. N\'importe qui avec le lien peut la voir.',
    ],
    'labels'    => [
        'member_link'   => 'Lien réservé aux membres',
        'public_link'   => 'Lien public',
        'share_link'    => 'Lien de partage',
    ],
    'options'   => [
        'keep_private'          => 'Garder la campagne privée',
        'make_all_public'       => 'Montrer toutes les :module aux non-membres',
        'make_campaign_public'  => 'Rendre la campagne publique',
        'make_entity_public'    => 'Montrer :name aux non-membres',
    ],
    'status'    => [
        'hidden'    => 'Non visible pour les non-membres',
        'private'   => 'Cette campagne est privée',
        'public'    => 'Visible pour les non-membres',
        'unlisted'  => 'Visible par n\'importe qui avec le lien',
    ],
    'success'   => [
        'copied'            => 'Lien copié dans le presse-papiers!',
        'copied_members'    => 'Lien réservé aux membres copié.',
        'copied_public'     => 'Lien public copié, n\'importe qui avec le lien peut voir l\'entrée.',
        'updated'           => 'Paramètres de visibilité mis à jour.',
    ],
    'title'     => 'Partager l\'entrée',
];
