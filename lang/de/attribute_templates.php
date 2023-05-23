<?php

return [
    'attribute_templates'   => [
        'title' => ':name Attributsvorlagen',
    ],
    'create'                => [
        'title' => 'Erstelle eine neue Attributvorlage',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attributes'    => 'Attribute',
    ],
    'hints'                 => [
        'automatic'                 => 'Attribute wurden automatisch aus der Attribut-Vorlage ":link" erstellt.',
        'entity_type'               => 'Wenn diese Option aktiviert ist, wird beim Erstellen eines neuen Objekts dieses Typs diese Attributvorlage automatisch angewendet.',
        'parent_attribute_template' => 'Diese Attributvorlage kann eine übergeordnete Attributvorlage haben. Wenn man diese Vorlage anwendet, werden sie und alle übergeordneten Vorlagen angewendet.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Name der Attributvorlage',
    ],
    'show'                  => [
        'tabs'  => [
            'attributes'    => 'Attribute',
        ],
    ],
];
