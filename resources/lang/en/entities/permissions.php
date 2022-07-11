<?php

return [
    'quick' => [
        'empty-permissions' => 'No role or user outside of the campaign admins have access to this entity.',
        'field'             => 'Quick edit',
        'options'           => [
            'private'   => 'Private to all but admins',
            'visible'   => 'Visible to the following',
        ],
        'private'           => 'Only members of the campaign\'s admin role can currently see this entity.',
        'public'            => 'This entity is currently visible from any user or role with access to it.',
        'success'           => [
            'private'   => ':entity is now hidden.',
            'public'    => ':entity is now visible.',
        ],
        'title'             => 'Permission overview',
        'viewable-by'       => 'Viewable by',
    ],
];
