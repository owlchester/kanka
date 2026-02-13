<?php

return [
    'create'        => [
        'title' => 'New Property Kit',
    ],
    'fields'        => [
        'auto_apply'    => 'Auto-apply',
        'is_enabled'    => 'Enabled',
    ],
    'hints'         => [
        'automatic'                 => 'The following :count properties were automatically applied from :link.',
        'automatic_apply'           => '{1} The following :count property was automatically applied from :link | [2,] The following :count properties were automatically applied from :link.',
        'entity_type'               => 'Automatically apply this kit\'s properties to new entries of the selected category.',
        'is_disabled'               => 'This kit is disabled.',
        'is_enabled'                => 'Enable this kit for use in the campaign.',
        'parent_attribute_template' => 'This property kit can be a child of another property kit. When applying this property kit, it and all of its parents will be applied.',
    ],
    'lists'         => [
        'empty' => 'Create kit to reuse common properties across multiple entries.',
    ],
    'placeholders'  => [
        'name'  => 'Name of the property kit',
    ],
];
