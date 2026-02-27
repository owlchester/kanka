<?php

return [
    'create'        => [
        'title' => 'Créer un nouveau kit de propriétés',
    ],
    'fields'        => [
        'attributes'    => 'Propriétés',
        'auto_apply'    => 'Auto-appliquer',
        'is_enabled'    => 'Activé',
    ],
    'hints'         => [
        'automatic'                 => 'Propriétés automatiquement appliqués depuis le kit :link.',
        'automatic_apply'           => '1} La propriété suivante a été automatiquement appliquée pour :link | [2,] Les :count propriétées suivantes ont été automatiquement appliquées pour :link.',
        'entity_type'               => 'Si défini, lors de la création d\'une nouvelle entrée de cette catégorie, ce kit ainsi que ses parents seront automatiquement appliqués.',
        'is_disabled'               => 'Ce kit est désactivé.',
        'is_enabled'                => 'Activer ce kit pour l\'utiliser.',
        'parent_attribute_template' => 'Ce kit peut être l\'enfant d\'un autre kit. Lorsqu\'un kit est appliqué, celui-ci ainsi que tous ses descendants seront aussi appliqués.',
    ],
    'lists'         => [
        'empty' => 'Créé des kits pour réutiliser des propriétés communes à plusieurs entrées.',
    ],
    'placeholders'  => [
        'name'  => 'Nom du kit de propriétés',
    ],
    'show'          => [
        'tabs'  => [
            'attributes'    => 'Propriétés',
        ],
    ],
];
