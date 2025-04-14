<?php

return [
    'create'        => [
        'title' => 'New Race',
    ],
    'fields'        => [
        'members'   => 'Members',
    ],
    'hints'         => [
        'is_extinct'    => 'This race is extinct.',
    ],
    'members'       => [
        'create'    => [
            'submit'    => 'Add members',
            'success'   => '{0} No member was added.|{1} 1 member was added.|[2,*] :count members were added.',
            'title'     => 'New Members',
            'helper'    => 'Add one or several characters to :name.',
        ],
    ],
    'placeholders'  => [
        'type'  => 'Human, Fey, Borg',
    ],
];
