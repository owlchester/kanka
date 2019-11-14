<?php

return [
    'create'        => [
        'description'   => 'Create a new family',
        'success'       => 'Family \':name\' created.',
        'title'         => 'New Family',
    ],
    'destroy'       => [
        'success'   => 'Family \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Family \':name\' updated.',
        'title'     => 'Edit Family :name',
    ],
    'families'      => [
        'title' => 'Family :name Families',
    ],
    'fields'        => [
        'families'  => 'Sub Families',
        'family'    => 'Parent Family',
        'image'     => 'Image',
        'location'  => 'Location',
        'members'   => 'Members',
        'name'      => 'Name',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'This list contains all families which are descendants of this family, and not only those directly under it.',
        'nested'        => 'When in Nested View, you can view your Families in a nested manner. Families with no parent family will be shown by default. Families with sub families can be clicked to view those children. You can keep clicking until there are no more children to view.',
    ],
    'hints'         => [
        'members'   => 'Members of a family are listed here. A character can be added to a family by editing the desired character and using the "Family" dropdown.',
    ],
    'index'         => [
        'add'           => 'New Family',
        'description'   => 'Manage the families of :name.',
        'header'        => 'Families of :name',
        'title'         => 'Families',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'The following list are all characters that are in this family and all of the family\'s descendant families.',
            'direct_members'    => 'Most families have members who run it or made it famous. The following list are characters that are directly in this family.',
        ],
        'title'     => 'Family :name Members',
    ],
    'placeholders'  => [
        'location'  => 'Choose a location',
        'name'      => 'Name of the family',
        'type'      => 'Royal, Noble, Extinct',
    ],
    'show'          => [
        'description'   => 'A detailed view of a family',
        'tabs'          => [
            'all_members'   => 'All Members',
            'families'      => 'Families',
            'members'       => 'Members',
            'relation'      => 'Relations',
        ],
        'title'         => 'Family :name',
    ],
];
