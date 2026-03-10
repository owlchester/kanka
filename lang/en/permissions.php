<?php

return [
    'helpers'   => [
        'delete'    => 'Permission to delete this element',
        'edit'      => 'Permission to edit this element',
        'view'      => 'Permission to view this element',
    ],
    'members'   => [
        'inherited' => ':member can already do this by being part of the :role role.',
    ],
    'roles'     => [
        'inherited' => 'The :role role can already do this on the whole :module category.',
    ],
];
