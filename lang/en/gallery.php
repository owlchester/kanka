<?php

return [
    'actions'   => [
        'gallery'   => 'From gallery',
        'url'       => 'Upload an image from a URL',
    ],
    'browse'    => [
        'layouts'       => [
            'large' => 'Large previews',
            'small' => 'Small previews',
        ],
        'search'        => [
            'placeholder'   => 'Search for an image in the gallery',
        ],
        'title'         => 'Gallery',
        'unauthorized'  => 'None of your roles have the "browse gallery" permission.',
    ],
    'cta' => [
        'title' => 'Storage full',
        'action' => 'Unlock more storage space',
        'helper' => 'Unlock up to :size GiB storage space with a :premium-campaign.'
    ],
    'delete'    => [
        'success'   => '[0] Deleted 0 elements|[1] Deleted one element|{2,*} Deleted :count elements',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'Our servers couldn\'t download the given image.',
            'gallery_full_free'     => 'The gallery storage space is full. Enable premium features for more storage.',
            'gallery_full_premium'  => 'The gallery storage space is full. Remove unused files first.',
            'invalid_format'        => 'The file isn\'t a valid file format.',
            'too_big'               => 'The file is too large (:size MiB vs :max MiB)',
            'unauthorized'          => 'None of your roles have the "upload to gallery" permission.',
        ],
    ],
    'file'      => [
        'saved' => 'Saved',
    ],
    'filters'   => [
        'only_unused'   => 'Only show unused files',
    ],
    'move'      => [
        'success'   => '[0] Moved 0 elements|[1] Moved one element|{2,*} Moved :count elements',
    ],
    'update'    => [
        'home'      => 'Home folder',
        'success'   => '[0] Updated 0 elements|[1] Updated one element|{2,*} Updated :count elements',
    ],
];
