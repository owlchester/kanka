<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Displaying all the characters related to this race and it\'s sub races.',
            'characters'        => 'Displaying all the characters directly related to this race.',
        ],
    ],
    'create'        => [
        'title' => 'New Race',
    ],
    'fields'        => [
        'members'   => 'Members',
    ],
    'helpers'       => [
        'nested_without'    => 'Displaying all races that don\'t have a parent race. Click on a row to see the children races.',
    ],
    'members'       => [
        'create'    => [
            'submit'    => 'Add members',
            'success'   => '{0} No member was added.|{1} 1 member was added.|[2,*] :count members were added.',
            'title'     => 'New Members',
        ],
    ],
    'placeholders'  => [
        'type'  => 'Human, Fey, Borg',
    ],
];
