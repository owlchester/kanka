<?php

return [
    'helpers'   => [
        'admin'         => 'Only members of the Admin role can view this element.',
        'admin-self'    => 'Only you and members of the Admin role can view this element.',
        'all'           => 'Everyone can view this element.',
        'members'       => 'Only members of the campaign can view this element.',
        'self'          => 'Only you can see this element.',
    ],
    'picker'    => [
        'admin'         => 'Only visible to members of the :admin role.',
        'admin-self'    => 'Only you and members of the :admin role can see this.',
        'all'           => 'Anyone who can see :entity can see this.',
        'failed'        => 'Failed to update visibility.',
        'member'        => 'Only visible to campaign members. Useful for public campaigns.',
        'self'          => 'Only you can see this.',
    ],
    'title'     => 'Updating visibility',
    'toast'     => 'Successfully updated visibility.',
    'tooltip'   => 'Click to learn about the various visibility options and what they mean in our documentation.',
];
