<?php

return [
    'create'        => [
        'title' => 'New Family',
    ],
    'hints'         => [
        'is_extinct'    => 'This family is extinct.',
        'members'       => 'Members of a family are listed here. A character can be added to a family by editing the desired character and using the "Family" dropdown.',
    ],
    'members'       => [
        'create'    => [
            'success'   => '{0} No member was added.|{1} 1 member was added.|[2,*] :count members were added.',
            'title'     => 'New Members',
            'helper' => 'Add one or several members to :name.'
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name of the family',
        'type'  => 'Royal, Noble, Extinct',
    ],
    'show'          => [
        'tabs'  => [
            'tree'      => 'Family tree',
        ],
    ],
];
