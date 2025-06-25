<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Erstelle eine neue Attributvorlage',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attributes'    => 'Attribute',
        'auto_apply'    => 'automatisch übernehmen',
        'is_enabled'    => 'Aktiviert',
    ],
    'hints'                 => [
        'automatic'                 => 'Attribute wurden automatisch aus der Attribut-Vorlage ":link" erstellt.',
        'automatic_apply'           => '{1} Das folgende :count-Attribut wurde automatisch von :link übernommen | [2,] Die folgenden :count-Attribute wurden automatisch von :link übernommen.',
        'entity_type'               => 'Wenn diese Option aktiviert ist, wird beim Erstellen eines neuen Objekts dieses Typs diese Attributvorlage automatisch angewendet.',
        'is_disabled'               => 'Diese Vorlage ist deaktiviert.',
        'is_enabled'                => 'Aktiviere diese Vorlage zur Verwendung in der Kampagne.',
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
