<?php

return [
    'actions'           => [
        'customise' => 'Customise sidebar',
    ],
    'create'            => [
        'title' => 'New bookmark',
    ],
    'edit'              => [
        'title' => 'Bookmark :name',
    ],
    'fields'            => [
        'active'            => 'Active',
        'dashboard'         => 'Dashboard',
        'default_dashboard' => 'Default dashboard',
        'filters'           => 'Filters',
        'menu'              => 'Subpage',
        'position'          => 'Position',
        'random_type'       => 'Random Category',
        'selector'          => 'Bookmark Configuration',
        'target'            => 'Target',
    ],
    'helpers'           => [
        'active'            => 'Inactive bookmarks won\'t appear in the interface.',
        'css'               => 'Add a CSS class that will be added to the bookmark\'s link in the sidebar.',
        'dashboard'         => 'Have the bookmarks target a custom dashboards.',
        'default_dashboard' => 'Link to the default dashboard instead. A custom dashboard still needs to be selected.',
        'entity'            => 'Set up this bookmark to go directly to an entry. The :menu field controls which subpage of the entry is opened.',
        'position'          => 'Use this field to control in which ascending order the links appear in the menu.',
        'random'            => 'Use this field to have a bookmark pointing to a random entry. You can filter the link to only go to a specific category.',
        'selector'          => 'Configure where this bookmark goes when a user clicks on it in the sidebar.',
        'type'              => 'Set up this bookmark to go directly to a list of entries. To filter the results, copy parts of the url on the filtered entry list after the :? sign into the :filter field.',
    ],
    'lists'             => [
        'empty' => 'Save bookmarks to your most used entries or filtered lists for faster access.',
    ],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Menu subpage (use the last text of the url)',
        'tab'       => '(deprecated)',
    ],
    'random_no_entity'  => 'No random entry found.',
    'random_types'      => [
        'any'   => 'Any entry',
    ],
    'reorder'           => [
        'success'   => 'Bookmarks reordered.',
        'title'     => 'Reorder bookmarks',
    ],
    'targets'           => [
        'dashboard' => 'A dashboard',
        'entity'    => 'A single entry',
        'random'    => 'A random entry',
        'select'    => 'Choose an option',
        'type'      => 'Category entries',
    ],
    'visibilities'      => [
        'is_active' => 'Show the bookmark in the sidebar',
    ],
];
