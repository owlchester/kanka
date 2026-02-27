<?php

return [
    'actions'       => [
        'copy'      => 'Copier',
        'transfer'  => 'Transférer',
    ],
    'errors'        => [
        'permission'        => 'Une entrée de cette catégorie ne peut pas être créée dans la campagne ciblée.',
        'permission_update' => 'Cette entrée ne peut pas être déplacée.',
        'same_campaign'     => 'Une autre campagne doit être sélectionnée.',
        'unknown_campaign'  => 'Campagne inconnue.',
    ],
    'fields'        => [
        'campaign'      => 'Campagne cible',
        'copy'          => 'Faire une copie',
        'select_one'    => 'Sélectionner une campagne',
    ],
    'helpers'       => [
        'copy'  => 'Créer une copie de cette entrée dans la campagne cible.',
    ],
    'panel'         => [
        'description'           => 'Sélectionner une campagne vers laquelle cette entrée sera déplacée ou copiée.',
        'description_bulk_copy' => 'Sélectionner une campagne vers laquelle cette entrée sera copiée.',
        'title'                 => 'Déplacer ou copier une entrée vers une autre campagne',
    ],
    'success'       => 'L\'entrée :name a été déplacée.',
    'success_copy'  => 'L\'entrée :name a été copiée.',
    'title'         => 'Déplacer :name',
    'warnings'      => [
        'custom'    => 'Cette entrée n\'est pas d\'une catégorie par défaut, mais d\'une catégorie personnalisée ":module". Elle sera créée en tant que Note dans la campagne cible.',
    ],
];
