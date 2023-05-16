<?php

return [
    'attribute_templates'   => [
        'title' => ':name attribute templates',
    ],
    'create'                => [
        'title' => 'New Attribute Template',
    ],
    'fields'                => [
        'attributes'    => 'Attributes',
    ],
    'hints'                 => [
        'automatic'                 => 'Attributes automatically applied from the :link Attribute Template.',
        'entity_type'               => 'If set, creating a new entity of this type will automatically have this attribute template applied to it.',
        'parent_attribute_template' => 'This attribute template can be a child of another attribute template. When applying this attribute template, it and all of its parents will be applied.',
    ],
    'placeholders'          => [
        'name'  => 'Name of the Attribute Template',
    ],
    'show'                  => [
        'tabs'  => [
            'attributes'    => 'Attributes',
        ],
    ],
];
