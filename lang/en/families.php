<?php

return [
    'create'        => [
        'title' => 'New Family',
    ],
    'fields'        => [
        'members'   => 'Members',
    ],
    'hints'         => [
        'is_extinct'    => 'This family is extinct.',
        'members'       => 'Members of a family are listed here. A character can be added to a family by editing the desired character and using the "Family" dropdown.',
    ],
    'members'       => [
        'create'    => [
            'submit'    => 'Add members',
            'success'   => '{0} No member was added.|{1} 1 member was added.|[2,*] :count members were added.',
            'title'     => 'New Members',
        ],
        'helpers'   => [
            'all_members'       => 'The following list are all characters that are in this family and all of the family\'s descendant families.',
            'direct_members'    => 'Most families have members who run it or made it famous. The following list are characters that are directly in this family.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name of the family',
        'type'  => 'Royal, Noble, Extinct',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Members',
            'tree'      => 'Family tree',
        ],
    ],
];
