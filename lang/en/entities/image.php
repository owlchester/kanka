<?php

return [
    'actions'               => [
        'change_focus'  => 'Change focus point',
        'change_visibility'  => 'Change visibility',
        'replace_image' => 'Replace image',
        'save-replace'  => 'Replace image',
        'save_focus'    => 'Save focus point',
        'view'          => 'View image',
    ],
    'call-to-action'        => 'Click on the entity\'s image to set it\'s focus point instead of using the automated guess.',
    'focus'                 => [
        'breadcrumb'    => 'Image focus',
        'helper'        => 'Click on the image to set the focus point. Click on the focus point to remove it.',
        'panel_title'   => 'Image focus',
        'success'       => 'Image focus updated.',
        'title'         => 'Image Focus for :name',
        'unboosted'     => 'Setting an image focus point is reserverd to :boosted-campaigns.',
        'warning'       => 'The focus point for :gallery images is shared by all entities that use that same image.',
    ],
    'gallery_permissions'   => [
        'admin'     => 'This gallery image is only visible to the members of the campaign\'s :admin role.',
        'adminself' => 'This gallery image is only visible to :creator and the members of the campaign\'s :admin role.',
        'member'    => 'This gallery image is only visible to the members of the campaign.',
        'self'      => 'This gallery image is only visible to you.',
    ],
    'replace'               => [
        'breadcrumb'    => 'Image replacement',
        'panel_title'   => 'Entity image replacement',
        'success'       => 'Image replaced.',
        'title'         => 'Image replacement',
    ],
    'visibility' => [
        'helper' => 'Change the gallery image\'s visibility, controlling who can view it.',
        'updated' => 'Image visibility updated.',
    ]
];
