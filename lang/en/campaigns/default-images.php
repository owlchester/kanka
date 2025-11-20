<?php

return [
    'title' => 'Placeholder images',
    'actions'           => [
        'add'   => 'New thumbnail',
    ],
    'call-to-action'    => 'Upload a custom thumbnail for all the characters, locations, or other entities of the campaign. These images are then shown on various lists.',
    'create'            => [
        'error'     => 'Error saving the new default entity thumbnails. Is :type already set?',
        'helper'    => 'Upload an image that will be used as the default thumbnail for entities of the selected module.',
        'success'   => 'New thumbnail for :type created.',
        'title'     => 'New default thumbnail',
    ],
    'destroy'           => [
        'success'   => 'Default thumbnail for :type removed.',
    ],
    'tutorial' => 'Set default images for entities without custom pictures. These thumbnails appear immediately across the campaign and keep lists visually consistent.',
    'empty'             => 'No modules currently have a default thumbnail setup.',
    'helper'            => 'Used for all entities of this module without an image.',
];
