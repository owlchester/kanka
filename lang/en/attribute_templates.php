<?php

return [
    'create'        => [
        'title' => 'New Attribute Template',
    ],
    'fields'        => [
        'auto_apply'    => 'Auto-apply',
        'is_enabled'    => 'Enabled',
    ],
    'hints'         => [
        'automatic'                 => 'The following :count properties were automatically applied from :link.',
        'automatic_apply'           => '{1} The following :count property was automatically applied from :link | [2,] The following :count properties were automatically applied from :link.',
        'entity_type'               => 'Automatically apply this template\'s properties to new entries of the selected category.',
        'is_disabled'               => 'This template is disabled.',
        'is_enabled'                => 'Enable this template for use in the campaign.',
        'parent_attribute_template' => 'This attribute template can be a child of another attribute template. When applying this attribute template, it and all of its parents will be applied.',
    ],
    'lists'         => [
        'empty' => 'Create templates to reuse common properties across multiple entries.',
    ],
    'placeholders'  => [
        'name'  => 'Name of the Attribute Template',
    ],
];
