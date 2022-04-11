<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Add to tag',
        ],
        'create'    => [
            'success'   => 'Added the tag :name to the entity.',
            'title'     => 'Add an entity to :name',
        ],
        'title'     => 'Tag :name Children',
    ],
    'create'        => [
        'success'   => 'Tag \':name\' created.',
        'title'     => 'New Tag',
    ],
    'destroy'       => [
        'success'   => 'Tag \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Tag \':name\' updated.',
        'title'     => 'Edit Tag :name',
    ],
    'fields'        => [
        'children'  => 'Children',
        'name'      => 'Name',
        'tag'       => 'Parent Tag',
        'tags'      => 'Subtags',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'nested_parent' => 'Displaying the tags of :parent.',
        'nested_without'=> 'Displaying all tags that don\'t have a parent tag. Click on a row to see the children tags.',
        'no_children'   => 'There are currently no entities tagged with this tag.',
    ],
    'hints'         => [
        'children'  => 'This list contains all the entities that are assigned to this tag or the tag\'s children.',
        'tag'       => 'This list contains all the tags are children of this tag or its children tags.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Nested View',
        ],
        'add'       => 'New Tag',
        'header'    => 'Tags in :name',
        'title'     => 'Tags',
    ],
    'new_tag'       => 'New Tag',
    'placeholders'  => [
        'name'  => 'Name of the tag',
        'tag'   => 'Choose a parent tag',
        'type'  => 'Lore, Wars, History, Religion, Vexillology',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Children',
            'tags'      => 'Tags',
        ],
        'title' => 'Tag :name',
    ],
    'tags'          => [
        'title' => 'Tag :name Children',
    ],
];
