<?php

return [
    'actions'       => [
        'close'         => 'Close',
        'file-link'     => 'File link',
        'focus_point'   => 'Focus point',
        'image-link'    => 'Image link',
        'reset_focus'   => 'Reset focus point',
        'save'          => 'Save',
        'upgrade' => 'Upgrade storage space',
    ],
    'breadcrumb'    => 'Gallery',
    'bulk'          => [
        'destroy'   => [
            'confirm'   => 'Are you sure you want to permanently remove the selected elements? This action cannot be undone.',
            'success'   => '{0}No files removed.|{1}One file removed.|{2,*} :count files removed.',
        ],
    ],
    'cta'           => 'Manage and reuse images throughout the campaign.',
    'destroy'       => [
        'folder'    => 'Folder :name deleted.',
        'success'   => 'File :name deleted.',
    ],
    'errors'        => [
        'max'           => 'Please only select up to :count files at a time.',
        'permissions'   => 'Your campaign roles are missing the :permission permission to be allowed to upload images to the campaign gallery.',
        'storage'       => 'There is not enough storage space to upload the selected image(s). Available storage space: :available.',
    ],
    'fields'        => [
        'details'   =>          'Details',
        'created_by'            => 'Uploaded by',
        'link'            => 'Link',
        'ext'                   => 'Ext',
        'file_type'                   => 'File type',
        'folder'                => 'Folder',
        'image_mentioned_in'    => '{0} This image isn\'t mentioned in any of the campaign\'s entities.|{1} Mentioned in one entry/post.|[2,*] mentioned in :count entries/posts.',
        'image_used_in'         => '{0} This image isn\'t used in any of the campaign\'s entities.|{1} Used as the image of one entity.|[2,*] Used as the image of :count entities.',
        'name'                  => 'Name',
        'size'                  => 'Size',
        'used_in'                  => 'Used in',
        'unused'                  => 'Not used anywhere',
    ],
    'focus'         => [
        'removed'   => 'Image focus removed.',
        'updated'   => 'Image focus updated.',
        'locked' => 'A premium campaign is required to set the focus point of an image.',
    ],
    'new_folder'    => [
        'title' => 'New folder',
    ],
    'no_folder'     => 'No folder',
    'pitch'         => 'Upload images to the campaign\'s gallery directly from the text editor.',
    'placeholders'  => [
        'search'    => 'Search image name...',
    ],
    'title'         => 'Campaign :campaign Gallery',
    'update'        => [
        'folder'    => 'Folder modified.',
        'success'   => 'File modified.',
    ],
    'storage' => [
        'title' => 'Storage',
        'of' => 'of',
    ],
    'uploader'      => [
        'add'           => 'Add new',
        'new_folder'    => 'New Folder',
        'or'            => 'or',
        'select_file'   => 'Select a file',
        'well'          => 'Drop file to upload',
    ],
];
