<?php

return [
    'actions'   => [
        'add'   => 'Add a new default image',
    ],
    'create'    => [
        'error'     => 'Error saving the new default entity images. Is :type already set?',
        'success'   => 'Default entity image for :type created.',
        'title'     => 'New default entity image',
    ],
    'destroy'   => [
        'success'   => 'Default entity image for :type removed.',
    ],
    'helper'    => 'Set custom default entity images for your campaign. These will be shown in the various lists, but not on the entity itself.',
    'index'     => [
        'title' => 'Default Entity Images',
    ],
    'title'     => 'Campaign :campaign Default Entity Images',
];
