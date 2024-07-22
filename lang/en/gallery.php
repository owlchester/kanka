<?php

return [
    'actions' => [
        'url' => 'Upload an image from a URL',
        'gallery' => 'From gallery',
    ],
    'browse' => [
        'title' => 'Gallery',
        'layouts' => [
            'small' => 'Small previews',
            'large' => 'Large previews',
        ],
        'search' => [
            'placeholder' => 'Search for an image in the gallery',
        ],
    ],
    'download' => [
        'errors' => [
            'copy_failed' => 'Our servers couldn\'t download the given image.',
            'invalid_format' => 'The file isn\'t a valid file format.',
            'too_big' => 'The file is too large.',
            'gallery_full_free' => 'The gallery storage space is full. Enable premium features for more storage.',
            'gallery_full_premium' => 'The gallery storage space is full. Remove unused files first.'
        ]
    ]
];
