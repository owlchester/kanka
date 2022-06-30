<?php

return [
    'quick' => [
        'field' => 'Quick edit',
        'viewable-by' => 'Viewable by',
        'options' => [
            'visible' => 'Visible to the following',
            'private' => 'Private to all but admins',
        ],
        'private'   => 'Only members of the campaign\'s admin role can currently see this entity.',
        'public'    => 'This entity is currently visible from any user or role with access to it.',
        'title'     => 'Permission overview',
        'success' => [
            'public' => ':entity is now visible.',
            'private' => ':entity is now hidden.',
        ],
        'empty-permissions' => 'No role or user outside of the campaign admins have access to this entity.',
    ],
];
