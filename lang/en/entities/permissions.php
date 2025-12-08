<?php

return [
    'privacy'   => [
        'text'      => 'This entity is set to private. Custom permissions can still be defined, but as long as the entity is private, those will be ignored, and only members of the campaign\'s :admin role will be able to see the entity.',
        'warning'   => 'Warning',
    ],
    'toggle' => [
        'label' => 'Entity privacy',
        'private' => [
            'title' => 'Private',
            'description' => 'Only visible to members of :admin role.'
        ],
        'public' => [
            'title' => 'Public',
            'description' => 'Visible to the following roles and users.',
        ],
    ],
    'quick'     => [
        'empty-permissions' => 'No role or user outside of the campaign admins have access to this entity.',
        'manage'            => 'Manage Permissions',
        'screen-reader'     => 'Open privacy settings',
        'success'           => [
            'private'   => ':entity is now hidden.',
            'public'    => ':entity is now visible.',
        ],
        'title'             => 'Permission overview',
        'viewable-by'       => 'Viewable by',
    ],
];
