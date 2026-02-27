<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Ajouter une nouvelle étiquette',
            'add_entity'    => 'Ajouter à une entity',
        ],
        'create'    => [
            'attach_success'        => '{1} Ajout de :count entrée à l\'étiquette :name.|[2,*] Ajout de :count entrées à l\'étiquette :name.',
            'attach_success_entity' => 'Etiquettes modifiées pour :name.',
            'entity'                => 'Etiquetter :name',
            'helper'                => 'Etiquetter une ou plusieurs entrées avec :name',
            'title'                 => 'Etiquetter',
        ],
    ],
    'create'        => [
        'title' => 'Nouvelle étiquette',
    ],
    'fields'        => [
        'children'          => 'Enfants',
        'is_auto_applied'   => 'Appliquer automatiquement aux nouvelles entrées',
        'is_hidden'         => 'Caché de l\'entête et des infobulles',
    ],
    'helpers'       => [
        'no_children'   => 'Il n\'y a actuellement aucune entrée avec cette étiquette.',
        'no_posts'      => 'Il n\'y a actuellement aucun article avec cette étiquette.',
    ],
    'hints'         => [
        'children'          => 'Cette liste contient toutes les entrées directement dans cette étiquette et toutes les étiquettes enfants.',
        'is_auto_applied'   => 'Si cette option est activée, les nouvelles entrées auront automatiquement cette étiquette.',
        'is_hidden'         => 'Si activé, cette étiquette ne s\'affichera pas dans l\'entête d\'entrée, ni dans les infobulles.',
        'tag'               => 'Affichées ci-dessous sont toutes les étiquettes enfants de cette étiquette.',
    ],
    'lists'         => [
        'empty' => 'Utilise des balises pour regrouper et filtrer les entrées dans ton univers afin de faciliter la navigation.',
    ],
    'placeholders'  => [
        'type'  => 'Légende, Guerres, Histoire, Religion',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Enfants',
        ],
    ],
    'transfer'      => [
        'entities'      => [
            'helper'    => 'Transférer les entrées étiquetées avec :name à une autre étiquette.',
            'title'     => 'Transférer les entrées',
        ],
        'fail'          => 'Les entrées de :tag n\'ont pas pu être transférées vers :newTag',
        'fail_post'     => 'Les articles de :tag n\'ont pas pu être transférés vers :newTag',
        'posts'         => [
            'helper'    => 'Transférer les articles étiquetés avec :name à une autre étiquette.',
            'title'     => 'Transférer les articles',
        ],
        'success'       => 'Les entrées de :tag ont été transférées vers :newTag',
        'success_post'  => 'Les articles de :tag ont été transférés vers :newTag',
        'transfer'      => 'Transférer',
    ],
];
