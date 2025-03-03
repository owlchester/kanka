<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Ajouter une nouvelle étiquette',
            'add_entity'    => 'Ajouter à une entity',
        ],
        'create'    => [
            'attach_success'        => '{1} Ajout de :count entité à l\'étiquette :name.|[2,*] Ajout de :count entités à l\'étiquette :name.',
            'attach_success_entity' => 'Etiquettes modifiées pour :name.',
            'entity'                => 'Etiquetter :name',
            'modal_title'           => 'Ajouter des entités à :name',
        ],
    ],
    'create'        => [
        'title' => 'Nouvelle étiquette',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Enfants',
        'is_auto_applied'   => 'Appliquer automatiquement aux nouvelles entités',
        'is_hidden'         => 'Caché de l\'entête et des infobulles',
    ],
    'helpers'       => [
        'no_children'   => 'Il n\'y a actuellement aucune entité avec cette étiquette.',
        'no_posts'      => 'Il n\'y a actuellement aucun article avec cette étiquette.',
    ],
    'hints'         => [
        'children'          => 'Cette liste contient toutes les entités directement dans cette étiquette et toutes les étiquettes enfants.',
        'is_auto_applied'   => 'Si cette option est activée, les nouvelles entités auront automatiquement cette étiquette.',
        'is_hidden'         => 'Si activé, cette étiquette ne s\'affichera pas dans l\'entête d\'entité, ni dans les infobulles.',
        'tag'               => 'Affichées ci-dessous sont toutes les étiquettes enfants de cette étiquette.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Légende, Guerres, Histoire, Religion',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Enfants',
        ],
    ],
    'tags'          => [],
    'transfer'      => [
        'description'       => 'Transférer les entités de cette étiquette vers une autre étiquette.',
        'fail'              => 'Les entités de :tag n\'ont pas pu être transférées vers :newTag',
        'fail_post'         => 'Les articles de :tag n\'ont pas pu être transférés vers :newTag',
        'post_description'  => 'Transférer les articles de cette étiquette vers une autre étiquette.',
        'success'           => 'Les entités de :tag ont été transférées vers :newTag',
        'success_post'      => 'Les articles de :tag ont été transférés vers :newTag',
        'title'             => 'Transférer :name',
        'transfer'          => 'Transférer',
    ],
];
