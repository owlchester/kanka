<?php

return [
    'privacy'   => [
        'text'      => 'This entity is set to private. Custom permissions can still be defined, but as long as the entity is private, those will be ignored, and only members of the campaign\'s :admin role will be able to see the entity.',
        'warning'   => 'Warning',
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
    'toggle'    => [
        'label'     => 'Entity privacy',
        'private'   => [
            'description'   => 'Only visible to members of :admin role.',
            'title'         => 'Private',
        ],
        'public'    => [
            'description'   => 'Visible to the following roles and members.',
            'title'         => 'Public',
        ],
    ],
];
