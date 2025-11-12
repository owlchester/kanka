<?php

return [
    'create'        => [
        'title' => 'New Attribute Template',
    ],
    'fields'        => [
        'attributes'    => 'Attributes',
        'auto_apply'    => 'Auto-apply',
        'is_enabled'    => 'Enabled',
    ],
    'hints'         => [
        'automatic'                 => 'The following :count attributes were automatically applied from :link.',
        'automatic_apply'           => '{1} The following :count attribute was automatically applied from :link | [2,] The following :count attributes were automatically applied from :link.',
        'entity_type'               => 'Automatically apply this template\'s attributes to new entities of the selected type.',
        'is_disabled'               => 'This template is disabled.',
        'is_enabled'                => 'Enable this template for use in the campaign.',
        'parent_attribute_template' => 'This attribute template can be a child of another attribute template. When applying this attribute template, it and all of its parents will be applied.',
    ],
    'lists' => [
        'empty' => 'Create templates to reuse common attributes across multiple entities.',
    ],
    'placeholders'  => [
        'name'  => 'Name of the Attribute Template',
    ],
    'show'          => [
        'tabs'  => [
            'attributes'    => 'Attributes',
        ],
    ],
];
