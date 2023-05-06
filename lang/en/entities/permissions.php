<?php

return [
    'privacy'   => [
        'text'      => 'This entity is set to private. Custom permissions can still be defined, but as long as the entity is private, those will be ignored, and only members of the campaign\'s :admin role will be able to see the entity.',
        'warning'   => 'Warning',
    ],
    'quick'     => [
        'empty-permissions' => 'No role or user outside of the campaign admins have access to this entity.',
        'field'             => 'Quick edit',
        'manage'            => 'Manage Permissions',
        'options'           => [
            'private'   => 'Private to all but admins',
            'visible'   => 'Visible to the following',
        ],
        'private'           => 'Only members of the campaign\'s admin role can currently see this entity.',
        'public'            => 'This entity is currently visible from any user or role with access to it.',
        'screen-reader'     => 'Open privacy settings',
        'success'           => [
            'private'   => ':entity is now hidden.',
            'public'    => ':entity is now visible.',
        ],
        'title'             => 'Permission overview',
        'viewable-by'       => 'Viewable by',
    ],
];
