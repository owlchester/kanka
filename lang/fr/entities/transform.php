<?php

return [
    'actions'       => [
        'convert'   => 'Convertis en module',
    ],
    'bulk'          => [
        'errors'    => [
            'unknown_type'  => 'Type inconnu ou invalid',
        ],
        'success'   => '{1} :count entité transformée au nouveau type: :type.|[2,*] :count entités transformées au nouveau type: :type.',
    ],
    'confirm'       => [
        'checkbox'  => 'Je comprends qu\'en transformant :entity en un autre module, les éléments suivants seront perdus:',
        'label'     => 'Confirmer la perte de données',
    ],
    'documentation' => 'Documentation : conversion des modules d\'entité',
    'fields'        => [
        'current'       => 'Module actuel',
        'select_one'    => 'Sélectionner un',
        'target'        => 'Nouveau type de l\'entité',
    ],
    'panel'         => [
        'bulk_description'  => 'Changes le type de plusieurs entitées. Attention cependant, certaines informations peuvent être perdues dû au différent champs sur les entités.',
        'bulk_title'        => 'Transformer plusieurs entités',
        'title'             => 'Transformer une entité',
        'warning'           => 'Certaines données peuvent ne pas être reprises si le nouveau module utilise des champs différents',
    ],
    'success'       => 'L\'entité :name a été transformée.',
    'title'         => 'Transformer :name',
];
