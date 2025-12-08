<?php

return [
    'actions'           => [
        'add'   => 'New placeholder',
    ],
    'call-to-action'    => 'Upload a custom thumbnail for all the characters, locations, or other entities of the campaign. These images are then shown on various lists.',
    'create'            => [
        'error'     => 'Error saving the new placeholder image. Is :type already set?',
        'helper'    => 'Upload an image that will be used as the placeholder image for entities of the selected module.',
        'success'   => 'New placeholder for :type created.',
        'title'     => 'New placeholder image',
    ],
    'destroy'           => [
        'success'   => 'Placeholder image for :type removed.',
    ],
    'empty'             => 'No modules currently have a placeholder image.',
    'helper'            => 'Used for all entities of this module without an image.',
    'reset'             => [
        'helper'    => 'Are you sure you want to remove the placeholder images for all campaign modules?',
        'success'   => 'Successfully removed all modules\' placeholder images.',
        'title'     => 'Reset placeholder images',
        'warning'   => 'This action is permanent and cannot be undone.',
    ],
    'title'             => 'Placeholder images',
    'tutorial'          => 'Set default images for entities without custom pictures. These thumbnails appear immediately across the campaign and keep lists visually consistent.',
];
