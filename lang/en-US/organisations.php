<?php

return [
    'create'        => [
        'title' => 'New Organization',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [],
    'helpers'       => [],
    'index'         => [],
    'members'       => [
        'destroy'   => [
            'success'   => 'Member removed from the organization.',
        ],
        'helpers'   => [
            'all_members'   => 'All characters that are members of this organizations and it\'s sub-organizations.',
            'members'       => 'All characters that are members of this organization.',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [],
    'quests'        => [],
    'show'          => [],
];
