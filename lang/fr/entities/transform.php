<?php

return [
    'actions'   => [
        'transform' => 'Transformer',
    ],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Type inconnu ou invalid',
        ],
        'success'   => '{1} :count entité transformée au nouveau type: :type.|[2,*] :count entités transformées au nouveau type: :type.',
    ],
    'confirm'   => [
        'checkbox'  => 'Je comprends qu\'en transformant :entity en un autre module, les éléments suivants seront perdus:',
        'label'     => 'Confirmer la perte de données',
    ],
    'fields'    => [
        'current'       => 'Module actuel',
        'select_one'    => 'Sélectionner un',
        'target'        => 'Nouveau type de l\'entité',
    ],
    'panel'     => [
        'bulk_description'  => 'Changes le type de plusieurs entitées. Attention cependant, certaines informations peuvent être perdues dû au différent champs sur les entités.',
        'bulk_title'        => 'Transformer plusieurs entités',
        'description'       => 'As-tu créé cette entité comme un type mais ensuite réalisé qu\'un autre type joue mieux? Pas de souci, le type d\'entité peut être modifié à tout moment. Attention cependant, certaines informations propres au type d\'entité peuvent être perdues lors de la transformation.',
        'title'             => 'Transformer une entité',
    ],
    'success'   => 'L\'entité :name a été transformée.',
    'title'     => 'Transformer :name',
];
