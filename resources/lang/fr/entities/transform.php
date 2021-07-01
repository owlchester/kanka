<?php

return [
    'actions'   => [
        'transform' => 'Transformer',
    ],
    'fields'    => [
        'select_one'    => 'Sélectionner un',
        'target'        => 'Nouveau type de l\'entité',
    ],
    'panel'     => [
        'description'   => 'As-tu créé cette entité comme un type mais ensuite réalisé qu\'un autre type joue mieux? Pas de souci, le type d\'entité peut être modifié à tout moment. Attention cependant, certaines informations propres au type d\'entité peuvent être perdues lors de la transformation.',
        'title'         => 'Transformer une entité',
    ],
    'success'   => 'L\'entité :name a été transformée.',
    'title'     => 'Transformer :name',
];
