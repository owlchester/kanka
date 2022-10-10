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
        'attribute_template'    => 'Übergeordnete Attributvorlage',
        'attributes'            => 'Attribute',
        'name'                  => 'Name',
    ],
    'hints'                 => [
        'automatic'                 => 'Attribute wurden automatisch aus der Attribut-Vorlage ":link" erstellt.',
        'entity_type'               => 'Wenn diese Option aktiviert ist, wird beim Erstellen eines neuen Objekts dieses Typs diese Attributvorlage automatisch angewendet.',
        'parent_attribute_template' => 'Diese Attributvorlage kann eine übergeordnete Attributvorlage haben. Wenn man diese Vorlage anwendet, werden sie und alle übergeordneten Vorlagen angewendet.',
    ],
    'index'                 => [
        'title' => 'Attributvorlagen',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Wähle eine Attributvorlage',
        'name'                  => 'Name der Attributvorlage',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Attributsvorlagen',
            'attributes'            => 'Attribute',
        ],
    ],
];
