<?php

return [
    'privacy'   => [
        'text'      => 'This entry is set to private. Custom permissions can still be defined, but as long as the entry is private, those will be ignored, and only members of the :admin role will be able to see the entry.',
        'warning'   => 'Warning',
    ],
    'quick'     => [
        'empty-permissions' => 'No role or user outside of the admins have access to this entry.',
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
        'label'     => 'Entry privacy',
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
