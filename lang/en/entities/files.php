<?php

return [
    'call-to-action'    => [
        'error'     => 'This entity has reach the maximum number of files it can hold.',
        'premium'   => 'Uploading more files requires a premium campaign.',
    ],
    'create'            => [
        'helper'            => 'Add a file to this entity. The file will count towards your gallery storage limit.',
        'success_plural'    => '{1} File :name added.|[2,*] :count files added.',
        'title'             => 'New file for :entity',
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
        'title'     => 'Update entity file',
    ],
];
