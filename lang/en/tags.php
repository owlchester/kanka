<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Add to tag',
            'add_entity'    => 'Add to entity',
        ],
        'create'    => [
            'attach_success'        => '{1} Tagged :count entity .|[2,*] Tagged :count entities.',
            'attach_success_entity' => 'Successfully updated tags for :name.',
            'entity'                => 'Add tags to :name',
            'helper'                => 'Tag one or several entities with :name',
            'title'                 => 'Tag entities',
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
    'lists' => [
        'empty' => 'Use tags to group and filter entities across your world for easier navigation.'
    ],
    'placeholders'  => [
        'type'  => 'Lore, Wars, History, Religion, Vexillology',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Children',
        ],
    ],
    'transfer'      => [
        'entities'      => [
            'helper'    => 'Transfer entities tagged with :name to another tag.',
            'title'     => 'Transfer entities',
        ],
        'fail'          => 'Failed to transfer entities from :tag to :newTag',
        'fail_post'     => 'Failed to transfer posts from :tag to :newTag',
        'posts'         => [
            'helper'    => 'Transfer posts tagged with :name to another tag.',
            'title'     => 'Transfer posts',
        ],
        'success'       => 'Successfully transferred entities from :tag to :newTag',
        'success_post'  => 'Successfully transferred posts from :tag to :newTag',
        'transfer'      => 'Transfer',
    ],
];
