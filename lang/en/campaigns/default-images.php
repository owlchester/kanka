<?php

return [
    'actions'           => [
        'add'   => 'New placeholder',
    ],
    'call-to-action'    => 'Give every character, location, or other category a default thumbnail, so your lists never look empty.',
    'create'            => [
        'error'     => 'Error saving the new placeholder image. Is :type already set?',
        'helper'    => 'Upload an image that will be used as the placeholder image for entries of the selected category.',
        'success'   => 'New placeholder for :type created.',
        'title'     => 'New placeholder image',
    ],
    'destroy'           => [
        'success'   => 'Placeholder image for :type removed.',
    ],
    'empty'             => 'No categories currently have a placeholder image.',
    'helper'            => 'Used for all entries of this category without an image.',
    'reset'             => [
        'helper'    => 'Are you sure you want to remove the placeholder images for all campaign categories?',
        'success'   => 'Successfully removed all categories\' placeholder images.',
        'title'     => 'Reset placeholder images',
        'warning'   => 'This action is permanent and cannot be undone.',
    ],
    'title'             => 'Placeholder images',
    'tutorial'          => 'Set default images for entries without custom pictures. These thumbnails appear immediately across the campaign and keep lists visually consistent.',
];
