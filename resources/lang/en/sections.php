<?php

return [
    'create'        => [
        'description'   => 'Create a new category',
        'success'       => 'Category \':name\' created.',
        'title'         => 'New Category',
    ],
    'destroy'       => [
        'success'   => 'Category \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Category \':name\' updated.',
        'title'     => 'Edit Category :name',
    ],
    'fields'        => [
        'characters'    => 'Characters',
        'children'      => 'Children',
        'name'          => 'Name',
        'section'       => 'Category',
        'sections'      => 'Subcategories',
        'type'          => 'Type',
    ],
    'helpers' => [
        'nested' => 'When in Nested View, you can view your categories in a nested manner. Categories with no parent category will be shown by default. Categories with children categories can be clicked to view those children. You can keep clicking until there are no more children to view.'
    ],
    'hints'         => [
        'children'  => 'This list contains all the entities directly in this category and in all nested categories.',
        'section'   => 'Displayed below are all the categories that are directly under this category.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Nested View',
        ],
        'add'           => 'New Category',
        'description'   => 'Manage the category of :name.',
        'header'        => 'Categories in :name',
        'title'         => 'Categories',
    ],
    'placeholders'  => [
        'name'      => 'Name of the category',
        'section'   => 'Choose a parent category',
        'type'      => 'Lore, Wars, History, Religion, Vexology',
    ],
    'show'          => [
        'description'   => 'A detailed view of a category',
        'tabs'          => [
            'children'      => 'Children',
            'information'   => 'Information',
            'sections'      => 'Categories',
        ],
        'title'         => 'Category :name',
    ],
];
