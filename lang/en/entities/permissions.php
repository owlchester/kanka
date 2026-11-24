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
    'share'     => [
        'add_member'            => 'Grant or restrict access for a member…',
        'advanced'              => 'Advanced permissions',
        'custom'                => 'Custom',
        'default'               => 'Default (Inherited)',
        'edit'                  => 'Can edit',
        'inherited_allow'       => 'Inherited: Can view',
        'inherited_deny'        => 'Inherited: No access',
        'members_empty'         => 'No members have custom access overrides. Use the search box above to add one.',
        'members_title'         => 'Members with custom access',
        'no_access'             => 'No access',
        'overridden_private'    => 'Overridden while private',
        'remove'                => 'Remove override',
        'roles_title'           => 'Roles',
        'view'                  => 'Can view',
    ],
    'toggle'    => [
        'current'   => 'Current',
        'label'     => 'Entry privacy',
        'private'   => [
            'description'   => 'Only visible to members of :admin role.',
            'title'         => 'Private',
        ],
        'public'    => [
            'description'   => 'Visible to the following roles and members.',
            'helper'        => 'Anyone with access to this world can view this entry, subject to their role permissions.',
            'title'         => 'Public',
        ],
    ],
];
