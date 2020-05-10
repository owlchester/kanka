<?php

return [
    'title' => 'Campaign :campaign Default Entity Images',
    'helper' => 'Set custom default entity images for your campaign. These will be shown in the various lists, but not on the entity itself.',
    'actions' => [
        'add' => 'Add a new default image',
    ],
    'create' => [
        'title' => 'New default entity image',
        'success' => 'Default entity image for :type created.',
        'error' => 'Error saving the new default entity images. Is :type already set?',
    ],
    'destroy' => [
        'success' => 'Default entity image for :type removed.',
    ],
    'index' => [
        'title' => 'Default Entity Images',
    ],
];
