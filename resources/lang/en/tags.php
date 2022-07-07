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
        'title' => 'New Tag',
    ],
    'fields'        => [
        'children'  => 'Children',
        'name'      => 'Name',
        'tag'       => 'Parent Tag',
        'tags'      => 'Subtags',
        'type'      => 'Type',
        'is_auto_applied' => 'Automatically apply to new entities',
    ],
    'helpers'       => [
        'nested_without'=> 'Displaying all tags that don\'t have a parent tag. Click on a row to see the children tags.',
        'no_children'   => 'There are currently no entities tagged with this tag.',
    ],
    'hints'         => [
        'children'  => 'This list contains all the entities that are assigned to this tag or the tag\'s children.',
        'tag'       => 'This list contains all the tags are children of this tag or its children tags.',
        'is_auto_applied' => 'Check this option to automatically apply this tag to newly created entities.',
    ],
    'index'         => [
        'title' => 'Tags',
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
    ],
    'tags'          => [
        'title' => 'Tag :name Children',
    ],
];
