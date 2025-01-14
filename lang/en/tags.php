<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Add to tag',
            'add_entity'    => 'Add to entity',
        ],
        'create'    => [
            'attach_success'        => '{1} Added :count entity to tag :name.|[2,*] Added :count entities to tag :name.',
            'attach_success_entity' => 'Succesfully updated tags for :name.',
            'entity'                => 'Add tags to :name',
            'modal_title'           => 'Add entities to :name',
        ],
    ],
    'create'        => [
        'title' => 'New Tag',
    ],
    'fields'        => [
        'children'          => 'Children',
        'is_auto_applied'   => 'Automatically apply to new entities',
        'is_hidden'         => 'Hidden from header and tooltip',
    ],
    'helpers'       => [
        'no_children'   => 'There are currently no entities tagged with this tag.',
        'no_posts'      => 'There are currently no posts tagged with this tag.',
    ],
    'hints'         => [
        'children'          => 'This list contains all the entities that are assigned to this tag or the tag\'s children.',
        'is_auto_applied'   => 'Automatically apply this tag to newly created entities.',
        'is_hidden'         => 'Don\'t display this tag in an entity\'s header or tooltip.',
        'tag'               => 'This list contains all the tags are children of this tag or its children tags.',
    ],
    'placeholders'  => [
        'type'  => 'Lore, Wars, History, Religion, Vexillology',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Children',
            'posts'     => 'Tagged posts'
        ],
    ],
    'transfer'      => [
        'description'   => 'Move this tag\'s entities to another tag.',
        'fail'          => 'Failed to transfer entities from :tag to :newTag',
        'success'       => 'Successfully transferred entities from :tag to :newTag',
        'title'         => 'Transfer :name',
        'transfer'      => 'Transfer',
    ],
];
