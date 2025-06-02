<?php

return [
    'call-to-action'    => [
        'max'       => [
            'helper'    => 'You can\'t attach any more files unless you remove an existing one.',
            'limit'     => 'This entity has reached its file limit',
        ],
        'upgrade'   => [
            'limit'     => 'You\'ve reached the limit of :limit files for this entity',
            'upgrade'   => 'Upgrade to a premium campaign to attach up to :limit files and unlock even more creative flexibility.',
        ],
    ],
    'create'            => [
        'helper'            => 'Add a file to :name. The file will count towards the gallery storage limit.',
        'success_plural'    => '{1} File :name added.|[2,*] :count files added.',
        'title'             => 'New file',
    ],
    'destroy'           => [
        'success'   => 'File :name removed.',
    ],
    'fields'            => [
        'file'  => 'File',
        'files' => 'Files',
        'name'  => 'File name',
    ],
    'max'               => [
        'title' => 'Limit reached',
    ],
    'update'            => [
        'success'   => 'File :name updated.',
        'title'     => 'Update file',
    ],
];
