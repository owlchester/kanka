<?php

return [
    'actions'   => [
        'gallery'   => 'From gallery',
        'url'       => 'Upload an image from a URL',
    ],
    'browse'    => [
        'layouts'   => [
            'large' => 'Large previews',
            'small' => 'Small previews',
        ],
        'search'    => [
            'placeholder'   => 'Search for an image in the gallery',
        ],
        'title'     => 'Gallery',
        'unauthorized' => 'None of your roles have the "browse gallery" permission.',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'Our servers couldn\'t download the given image.',
            'gallery_full_free'     => 'The gallery storage space is full. Enable premium features for more storage.',
            'gallery_full_premium'  => 'The gallery storage space is full. Remove unused files first.',
            'invalid_format'        => 'The file isn\'t a valid file format.',
            'too_big'               => 'The file is too large.',
            'unauthorized'          => 'None of your roles have the "upload to gallery" permission.',
        ],
    ],
];
