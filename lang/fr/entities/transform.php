<?php

return [
    'actions'       => [
        'convert'   => 'Change la catégorie',
    ],
    'bulk'          => [
        'errors'    => [
            'unknown_type'  => 'Type inconnu ou invalide',
        ],
        'success'   => '{1} :count entrée transformée à la nouvelle catégorie :type.|[2,*] :count entrées transformées à la nouvelle catégorie :type.',
    ],
    'confirm'       => [
        'checkbox'  => 'Je comprends qu\'en changeant :entity vers une autre catégorie, les éléments suivants seront perdus:',
        'label'     => 'Confirmer la perte de données',
    ],
    'documentation' => 'Documentation : conversion des catégories d\'entrées',
    'fields'        => [
        'current'       => 'Catégorie actuelle',
        'select_one'    => 'Sélectionner un',
        'target'        => 'Nouveau type de l\'entrée',
    ],
    'panel'         => [
        'bulk_description'  => 'Changes la catégorie de plusieurs entrées. Attention cependant, certaines informations peuvent être perdues dû au différent champs sur les entrés.',
        'bulk_title'        => 'Transformer plusieurs entrées',
        'title'             => 'Transformer une entrée',
        'warning'           => 'Certaines données peuvent ne pas être reprises si la nouvelle catégorie utilise des champs différents',
    ],
    'success'       => 'L\'entrée :name a été transformée.',
    'title'         => 'Transformer :name',
];
