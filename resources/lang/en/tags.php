<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Add a new tag',
        ],
        'create'        => [
            'title' => 'Add a tag to :name',
        ],
        'description'   => 'Entities belonging to the tag',
        'title'         => 'Tag :name Children',
    ],
    'create'        => [
        'description'   => 'Create a new tag',
        'success'       => 'Tag \':name\' created.',
        'title'         => 'New Tag',
    ],
    'destroy'       => [
        'success'   => 'Tag \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Tag \':name\' updated.',
        'title'     => 'Edit Tag :name',
    ],
    'fields'        => [
        'characters'    => 'Characters',
        'children'      => 'Children',
        'name'          => 'Name',
        'tag'           => 'Parent Tag',
        'tags'          => 'Subtags',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'When in Nested View, you can view your tags in a nested manner. Tags with no parent tag will be shown by default. Tags with children tags can be clicked to view those children. You can keep clicking until there are no more children to view.',
    ],
    'hints'         => [
        'children'  => 'This list contains all the entities directly in this tag and in all nested tags.',
        'tag'       => 'Displayed below are all the tags that are directly under this tag.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Nested View',
        ],
        'add'           => 'New Tag',
        'description'   => 'Manage the tag of :name.',
        'header'        => 'Tags in :name',
        'title'         => 'Tags',
    ],
    'new_tag'       => 'New Tag',
    'placeholders'  => [
        'name'  => 'Name of the tag',
        'tag'   => 'Choose a parent tag',
        'type'  => 'Lore, Wars, History, Religion, Vexillology',
    ],
    'show'          => [
        'description'   => 'A detailed view of a tag',
        'tabs'          => [
            'children'      => 'Children',
            'information'   => 'Information',
            'tags'          => 'Tags',
        ],
        'title'         => 'Tag :name',
    ],
    'tags'          => [
        'description'   => 'Children Tags',
        'title'         => 'Tag :name Children',
    ],
];
