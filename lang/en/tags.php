<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Add to tag',
            'add_entity'    => 'Add to entry',
        ],
        'create'    => [
            'attach_success'        => '{1} Tagged :count entry.|[2,*] Tagged :count entries.',
            'attach_success_entity' => 'Successfully updated tags for :name.',
            'entity'                => 'Add tags to :name',
            'helper'                => 'Tag one or several entries with :name',
            'title'                 => 'Tag entries',
        ],
    ],
    'create'        => [
        'title' => 'New Tag',
    ],
    'fields'        => [
        'children'          => 'Children',
        'is_auto_applied'   => 'Automatically apply to new entries',
        'is_hidden'         => 'Hidden from header and tooltip',
    ],
    'helpers'       => [
        'no_children'   => 'There are currently no entries tagged with this tag.',
        'no_posts'      => 'There are currently no articles tagged with this tag.',
    ],
    'hints'         => [
        'children'          => 'This list contains all the entries that are assigned to this tag or the tag\'s children.',
        'is_auto_applied'   => 'Automatically apply this tag to newly created entries.',
        'is_hidden'         => 'Don\'t display this tag in an entry\'s header or tooltip.',
        'tag'               => 'This list contains all the tags are children of this tag or its children tags.',
    ],
    'lists'         => [
        'empty' => 'Use tags to group and filter entries across your world for easier navigation.',
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
            'helper'    => 'Transfer entries tagged with :name to another tag.',
            'title'     => 'Transfer entries',
        ],
        'fail'          => 'Failed to transfer entries from :tag to :newTag',
        'fail_post'     => 'Failed to transfer articles from :tag to :newTag',
        'posts'         => [
            'helper'    => 'Transfer articles tagged with :name to another tag.',
            'title'     => 'Transfer articles',
        ],
        'success'       => 'Successfully transferred entries from :tag to :newTag',
        'success_post'  => 'Successfully transferred articles from :tag to :newTag',
        'transfer'      => 'Transfer',
    ],
];
