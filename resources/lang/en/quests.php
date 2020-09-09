<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Set a character to a Quest',
            'success'       => 'Character added to :name.',
            'title'         => 'New Character for :name',
        ],
        'destroy'   => [
            'success'   => 'Quest character for :name removed.',
        ],
        'edit'      => [
            'description'   => 'Update a quest\'s character',
            'success'       => 'Quest character for :name updated.',
            'title'         => 'Update character for :name',
        ],
        'fields'    => [
            'character'     => 'Character',
            'description'   => 'Description',
        ],
        'title'     => 'Characters in :name',
    ],
    'create'        => [
        'description'   => 'Create a new quest',
        'success'       => 'Quest \':name\' created.',
        'title'         => 'New Quest',
    ],
    'destroy'       => [
        'success'   => 'Quest \':name\' removed.',
    ],
    'edit'          => [
        'description'   => 'Edit a quest',
        'success'       => 'Quest \':name\' updated.',
        'title'         => 'Edit Quest :name',
    ],
    'fields'        => [
        'character'     => 'Instigator',
        'characters'    => 'Characters',
        'copy_elements' => 'Copy elements attached to the quest',
        'date'          => 'Date',
        'description'   => 'Description',
        'image'         => 'Image',
        'is_completed'  => 'Completed',
        'items'         => 'Items',
        'locations'     => 'Locations',
        'name'          => 'Name',
        'organisations' => 'Organisations',
        'quest'         => 'Parent Quest',
        'quests'        => 'Sub Quests',
        'role'          => 'Role',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'When in Nested View, you can view your Quests in a nested manner. Quests with no parent quest will be shown by default. Quests with sub quests can be clicked to view those children. You can keep clicking until there are no more children to view.',
    ],
    'hints'         => [
        'quests'    => 'A web of interlocking quests can be built using the Parent Quest field.',
    ],
    'index'         => [
        'add'           => 'New Quest',
        'description'   => 'Manage the quests of :name.',
        'header'        => 'Quests of :name',
        'title'         => 'Quests',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Set an item to a Quest',
            'success'       => 'Item added to :name.',
            'title'         => 'New Item for :name',
        ],
        'destroy'   => [
            'success'   => 'Quest item for :name removed.',
        ],
        'edit'      => [
            'description'   => 'Update a quest\'s item',
            'success'       => 'Quest item for :name updated.',
            'title'         => 'Update item for :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'item'          => 'Item',
        ],
        'title'     => 'Items in :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Set an location to a Quest',
            'success'       => 'Location added to :name.',
            'title'         => 'New Location for :name',
        ],
        'destroy'   => [
            'success'   => 'Quest location for :name removed.',
        ],
        'edit'      => [
            'description'   => 'Update a quest\'s location',
            'success'       => 'Quest location for :name updated.',
            'title'         => 'Update location for :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'location'      => 'Location',
        ],
        'title'     => 'Locations in :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Set an organisation to a Quest',
            'success'       => 'Organisation added to :name.',
            'title'         => 'New Organisation for :name',
        ],
        'destroy'   => [
            'success'   => 'Quest organisation for :name removed.',
        ],
        'edit'      => [
            'description'   => 'Update a quest\'s organisation',
            'success'       => 'Quest organisation for :name updated.',
            'title'         => 'Update organisation for :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'organisation'  => 'Organisation',
        ],
        'title'     => 'Organisations in :name',
    ],
    'placeholders'  => [
        'date'  => 'Real world date for the quest',
        'name'  => 'Name of the quest',
        'quest' => 'Parent Quest',
        'role'  => 'This entity\'s role in the quest',
        'type'  => 'Character Arc, Sidequest, Main',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Add a character',
            'add_item'          => 'Add an item',
            'add_location'      => 'Add a location',
            'add_organisation'  => 'Add an organisation',
        ],
        'description'   => 'A detailed view of a quest',
        'tabs'          => [
            'characters'    => 'Characters',
            'information'   => 'Information',
            'items'         => 'Items',
            'locations'     => 'Locations',
            'organisations' => 'Organisations',
            'quests'        => 'Quests',
        ],
        'title'         => 'Quest :name',
    ],
];
