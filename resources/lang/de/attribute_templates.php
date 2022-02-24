<?php

return [
    'attribute_templates'   => [
        'title' => ':name Attributsvorlagen',
    ],
    'create'                => [
        'success'   => 'Attributvorlage \':name\' erstellt.',
        'title'     => 'Erstelle eine neue Attributvorlage',
    ],
    'destroy'               => [
        'success'   => 'Attributvorlage \':name\' entfernt.',
    ],
    'edit'                  => [
        'success'   => 'Attributvorlage \':name\' aktualisiert.',
        'title'     => 'Attributvorlage :name bearbeiten',
    ],
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
        'add'       => 'Neue Attributvorlage',
        'header'    => 'Attributvorlagen von :name',
        'title'     => 'Attributvorlagen',
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
        'title' => 'Attributvorlage :name',
    ],
];
