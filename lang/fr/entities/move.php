<?php

return [
    'actions'       => [
        'copy'  => 'Copier',
        'move'  => 'Déplacer',
    ],
    'errors'        => [
        'permission'        => 'Ce type d\'entité ne peut pas être créée dans la campagne ciblée.',
        'permission_update' => 'Cette entité ne peut pas être déplacée.',
        'same_campaign'     => 'Une autre campagne doit être sélectionnée.',
        'unknown_campaign'  => 'Campagne inconnue.',
    ],
    'fields'        => [
        'campaign'      => 'Campagne cible',
        'copy'          => 'Faire une copie',
        'select_one'    => 'Sélectionner une campagne',
    ],
    'helpers'       => [
        'copy'  => 'Créer une copie de cette entité dans la campagne cible.',
    ],
    'panel'         => [
        'description'           => 'Sélectionner une campagne vers laquelle cette entité sera déplacée ou copiée.',
        'description_bulk_copy' => 'Sélectionner une campagne vers laquelle cette entité sera copiée.',
        'title'                 => 'Déplacer ou copier une entité vers une autre campagne',
    ],
    'success'       => 'L\'entité :name a été déplacée.',
    'success_copy'  => 'L\'entité :name a été copiée.',
    'title'         => 'Déplacer :name',
    'warnings'      => [
        'custom'    => 'Cette entité n\'est pas d\'un module par défaut, mais d\'un module personnalisé ":module". Elle sera créée en tant que Note dans la campagne cible.',
    ],
];
